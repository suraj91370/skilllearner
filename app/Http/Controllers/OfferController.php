<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Offer;
use App\Models\OfferRedemption;
use App\Services\PackageService;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OfferController extends Controller
{
    /**
     * Super Admin Offer & Discount Management Center.
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $tab = $request->query('tab', 'offers');
        $search = trim((string) $request->query('search', ''));

        // 1. Load Offers (with DB and JSON fallback)
        $offers = collect();
        if (Schema::hasTable('offers')) {
            $offerQuery = Offer::latest();
            if ($search && $tab === 'offers') {
                $offerQuery->where('title', 'like', "%{$search}%")->orWhere('badge_text', 'like', "%{$search}%");
            }
            $offers = $offerQuery->get();
        } else {
            $offers = $this->loadOffersFromJson();
        }

        // 2. Load Coupons (with DB and JSON fallback)
        $coupons = collect();
        if (Schema::hasTable('coupons')) {
            $couponQuery = Coupon::latest();
            if ($search && $tab === 'coupons') {
                $couponQuery->where('code', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
            }
            $coupons = $couponQuery->get();
        } else {
            $coupons = $this->loadCouponsFromJson();
        }

        // 3. Load 5 Packages with base settings
        $packages = PackageService::getAllPackages(false);

        // 4. Load Offer Redemptions / Performance Reports
        $redemptions = collect();
        if (Schema::hasTable('offer_redemptions')) {
            $redemptions = OfferRedemption::latest()->paginate(25)->withQueryString();
        }

        // 5. Calculate KPI Metrics
        $totalRedemptionsCount = Schema::hasTable('offer_redemptions') ? OfferRedemption::count() : 0;
        $totalDiscountGiven = Schema::hasTable('offer_redemptions') ? (float) OfferRedemption::sum('discount_amount') : 0;
        $totalRevenueWithOffers = Schema::hasTable('offer_redemptions') ? (float) OfferRedemption::sum('final_amount') : 0;

        $stats = [
            'total_offers' => $offers->count(),
            'active_offers' => $offers->filter(fn ($o) => $o->status === 'active')->count(),
            'total_coupons' => $coupons->count(),
            'active_coupons' => $coupons->filter(fn ($c) => $c->status === 'active')->count(),
            'total_redemptions' => $totalRedemptionsCount,
            'total_discount_given' => $totalDiscountGiven,
            'total_revenue_with_offers' => $totalRevenueWithOffers,
        ];

        return view('admin.offers', [
            'active' => 'admin-offers',
            'currentTab' => $tab,
            'search' => $search,
            'offers' => $offers,
            'coupons' => $coupons,
            'packages' => $packages,
            'redemptions' => $redemptions,
            'stats' => $stats,
        ]);
    }

    /**
     * Store new Offer (Flash Sale, Festival, Flat Discount, Bundle).
     */
    public function storeOffer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'offer_type' => ['required', 'in:flash_sale,festival,discount,bundle'],
            'discount_type' => ['required', 'in:percentage,flat,bundle_free'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'applicable_packages' => ['nullable', 'array'],
            'applicable_packages.*' => ['string'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'banner_message' => ['nullable', 'string', 'max:500'],
            'bundle_buy_package' => ['nullable', 'string', 'max:50'],
            'bundle_free_package' => ['nullable', 'string', 'max:50'],
            'show_timer' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'status' => ['nullable', 'in:active,paused,expired'],
        ]);

        $slug = Str::slug($validated['title']).'-'.Str::random(4);
        $packages = ! empty($validated['applicable_packages']) ? $validated['applicable_packages'] : ['all'];
        $showTimer = $request->has('show_timer');
        $status = $validated['status'] ?? 'active';

        $offerData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'offer_type' => $validated['offer_type'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'applicable_packages' => $packages,
            'badge_text' => $validated['badge_text'] ?? ($validated['offer_type'] === 'flash_sale' ? '⚡ FLASH SALE' : '🎉 SPECIAL OFFER'),
            'banner_message' => $validated['banner_message'] ?? null,
            'bundle_buy_package' => $validated['bundle_buy_package'] ?? null,
            'bundle_free_package' => $validated['bundle_free_package'] ?? null,
            'show_timer' => $showTimer,
            'starts_at' => ! empty($validated['starts_at']) ? Carbon::parse($validated['starts_at']) : Carbon::now('Asia/Kolkata'),
            'ends_at' => ! empty($validated['ends_at']) ? Carbon::parse($validated['ends_at']) : null,
            'status' => $status,
            'uses_count' => 0,
            'total_discount_given' => 0,
        ];

        try {
            if (Schema::hasTable('offers')) {
                Offer::create($offerData);
            }
        } catch (\Throwable $e) {
            // Handled
        }

        // Always save to JSON backup
        $this->saveOfferToJson($offerData);

        return redirect()->route('admin.offers', ['tab' => 'offers'])
            ->with('success', "✅ Offer '{$validated['title']}' launched successfully!");
    }

    /**
     * Update existing offer.
     */
    public function updateOffer(Request $request, Offer $offer): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'offer_type' => ['required', 'in:flash_sale,festival,discount,bundle'],
            'discount_type' => ['required', 'in:percentage,flat,bundle_free'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'applicable_packages' => ['nullable', 'array'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'banner_message' => ['nullable', 'string', 'max:500'],
            'bundle_buy_package' => ['nullable', 'string'],
            'bundle_free_package' => ['nullable', 'string'],
            'show_timer' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'status' => ['required', 'in:active,paused,expired'],
        ]);

        $packages = ! empty($validated['applicable_packages']) ? $validated['applicable_packages'] : ['all'];
        $showTimer = $request->has('show_timer');

        $offer->update([
            'title' => $validated['title'],
            'offer_type' => $validated['offer_type'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'applicable_packages' => $packages,
            'badge_text' => $validated['badge_text'],
            'banner_message' => $validated['banner_message'],
            'bundle_buy_package' => $validated['bundle_buy_package'] ?? null,
            'bundle_free_package' => $validated['bundle_free_package'] ?? null,
            'show_timer' => $showTimer,
            'starts_at' => ! empty($validated['starts_at']) ? Carbon::parse($validated['starts_at']) : null,
            'ends_at' => ! empty($validated['ends_at']) ? Carbon::parse($validated['ends_at']) : null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.offers', ['tab' => 'offers'])
            ->with('success', "✅ Offer '{$offer->title}' updated successfully!");
    }

    /**
     * Toggle offer status between active and paused.
     */
    public function toggleOfferStatus(Request $request, $id): RedirectResponse
    {
        $newStatus = 'paused';
        $title = 'Offer';

        try {
            if (Schema::hasTable('offers')) {
                $offer = Offer::find($id);
                if ($offer) {
                    $newStatus = $offer->status === 'active' ? 'paused' : 'active';
                    $offer->update(['status' => $newStatus]);
                    $title = $offer->title;
                }
            }
        } catch (\Throwable $e) {
            // Handled
        }

        // Also update in JSON backup
        $jsonTitle = $this->updateOfferStatusInJson($id, $newStatus);
        if ($title === 'Offer' && $jsonTitle) {
            $title = $jsonTitle;
        }

        $label = $newStatus === 'active' ? 'Resumed (Active)' : 'Paused';

        return redirect()->route('admin.offers', ['tab' => 'offers'])
            ->with('success', "Offer '{$title}' is now {$label}.");
    }

    /**
     * Stop and immediately expire an offer.
     */
    public function stopOffer(Request $request, $id): RedirectResponse
    {
        $title = 'Offer';

        try {
            if (Schema::hasTable('offers')) {
                $offer = Offer::find($id);
                if ($offer) {
                    $offer->update([
                        'status' => 'expired',
                        'ends_at' => Carbon::now('Asia/Kolkata'),
                    ]);
                    $title = $offer->title;
                }
            }
        } catch (\Throwable $e) {
            // Handled
        }

        $jsonTitle = $this->stopOfferInJson($id);
        if ($title === 'Offer' && $jsonTitle) {
            $title = $jsonTitle;
        }

        return redirect()->route('admin.offers', ['tab' => 'offers'])
            ->with('success', "🛑 Offer '{$title}' has been stopped and marked as Expired! All flash timers and discounts have been removed from the homepage and checkout.");
    }

    /**
     * Delete an offer permanently.
     */
    public function destroyOffer(Request $request, $id): RedirectResponse
    {
        $title = 'Offer';

        try {
            if (Schema::hasTable('offers')) {
                $offer = Offer::find($id);
                if ($offer) {
                    $title = $offer->title;
                    $offer->delete();
                }
            }
        } catch (\Throwable $e) {
            // Handled
        }

        $jsonTitle = $this->deleteOfferFromJson($id);
        if ($title === 'Offer' && $jsonTitle) {
            $title = $jsonTitle;
        }

        return redirect()->route('admin.offers', ['tab' => 'offers'])
            ->with('success', "Offer '{$title}' permanently removed.");
    }

    /**
     * Store new Coupon Code.
     */
    public function storeCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', 'in:percentage,flat'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'applicable_packages' => ['nullable', 'array'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'status' => ['nullable', 'in:active,paused,expired'],
        ]);

        $code = strtoupper(trim($validated['code']));
        $packages = ! empty($validated['applicable_packages']) ? $validated['applicable_packages'] : ['all'];

        $couponData = [
            'code' => $code,
            'description' => $validated['description'] ?? null,
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0,
            'max_discount_amount' => $validated['max_discount_amount'] ?? null,
            'applicable_packages' => $packages,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'per_user_limit' => $validated['per_user_limit'] ?? 1,
            'used_count' => 0,
            'starts_at' => ! empty($validated['starts_at']) ? Carbon::parse($validated['starts_at']) : Carbon::now('Asia/Kolkata'),
            'expires_at' => ! empty($validated['expires_at']) ? Carbon::parse($validated['expires_at']) : null,
            'status' => $validated['status'] ?? 'active',
        ];

        try {
            if (Schema::hasTable('coupons')) {
                // If coupon with same code exists, update it
                Coupon::updateOrCreate(['code' => $code], $couponData);
            }
        } catch (\Throwable $e) {
            // Handled
        }

        $this->saveCouponToJson($couponData);

        return redirect()->route('admin.offers', ['tab' => 'coupons'])
            ->with('success', "🎟️ Coupon code '{$code}' created successfully!");
    }

    /**
     * Update existing coupon.
     */
    public function updateCoupon(Request $request, Coupon $coupon): RedirectResponse
    {
        $validated = $request->validate([
            'description' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', 'in:percentage,flat'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'applicable_packages' => ['nullable', 'array'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'status' => ['required', 'in:active,paused,expired'],
        ]);

        $packages = ! empty($validated['applicable_packages']) ? $validated['applicable_packages'] : ['all'];

        $coupon->update([
            'description' => $validated['description'] ?? null,
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0,
            'max_discount_amount' => $validated['max_discount_amount'] ?? null,
            'applicable_packages' => $packages,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'per_user_limit' => $validated['per_user_limit'] ?? 1,
            'starts_at' => ! empty($validated['starts_at']) ? Carbon::parse($validated['starts_at']) : null,
            'expires_at' => ! empty($validated['expires_at']) ? Carbon::parse($validated['expires_at']) : null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.offers', ['tab' => 'coupons'])
            ->with('success', "Coupon '{$coupon->code}' updated successfully!");
    }

    /**
     * Toggle coupon status between active and paused.
     */
    public function toggleCouponStatus(Request $request, $id): RedirectResponse
    {
        $newStatus = 'paused';
        $code = 'Coupon';

        try {
            if (Schema::hasTable('coupons')) {
                $coupon = Coupon::find($id);
                if ($coupon) {
                    $newStatus = $coupon->status === 'active' ? 'paused' : 'active';
                    $coupon->update(['status' => $newStatus]);
                    $code = $coupon->code;
                }
            }
        } catch (\Throwable $e) {
            // Handled
        }

        $jsonCode = $this->updateCouponStatusInJson($id, $newStatus);
        if ($code === 'Coupon' && $jsonCode) {
            $code = $jsonCode;
        }

        $label = $newStatus === 'active' ? 'Activated' : 'Paused';

        return redirect()->route('admin.offers', ['tab' => 'coupons'])
            ->with('success', "Coupon '{$code}' status set to {$label}.");
    }

    /**
     * Delete a coupon.
     */
    public function destroyCoupon(Request $request, $id): RedirectResponse
    {
        $code = 'Coupon';

        try {
            if (Schema::hasTable('coupons')) {
                $coupon = Coupon::find($id);
                if ($coupon) {
                    $code = $coupon->code;
                    $coupon->delete();
                }
            }
        } catch (\Throwable $e) {
            // Handled
        }

        $jsonCode = $this->deleteCouponFromJson($id);
        if ($code === 'Coupon' && $jsonCode) {
            $code = $jsonCode;
        }

        return redirect()->route('admin.offers', ['tab' => 'coupons'])
            ->with('success', "Coupon '{$code}' permanently deleted.");
    }

    /**
     * Update any of the 5 Core Packages (Price, MRP, Active Income, Passive Income, Badge).
     * Changes reflect everywhere: Homepage, Plans, Buy Now, Registration, and Commission payouts!
     */
    public function updatePackage(Request $request, string $slug): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'active_income' => ['required', 'numeric', 'min:0'],
            'passive_income' => ['required', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'desc' => ['nullable', 'string', 'max:1000'],
        ]);

        $success = PackageService::updatePackage($slug, $validated);

        if ($success) {
            return redirect()->route('admin.offers', ['tab' => 'packages'])
                ->with('success', "✅ {$validated['name']} pricing & commission updated! New price ₹".number_format($validated['price'])." is now active on the Homepage, Plans, and Checkout pages.");
        }

        return redirect()->route('admin.offers', ['tab' => 'packages'])
            ->with('error', "Failed to update package '{$slug}'.");
    }

    /**
     * AJAX endpoint to validate and calculate coupon discount at checkout.
     */
    public function applyCouponAjax(Request $request): JsonResponse
    {
        $code = (string) $request->input('code', '');
        $packageSlug = (string) $request->input('package', 'advance');
        $amount = $request->filled('amount') ? (float) $request->input('amount') : null;
        $userIdentifier = $request->input('email') ?: $request->input('phone');

        $result = PackageService::validateCoupon($code, $packageSlug, $amount, $userIdentifier);

        if ($result['valid']) {
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => $result['message'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 422);
    }

    /**
     * Web-based Migration Runner for Live Server.
     */
    public function runMigrationsWeb(Request $request): View
    {
        $output = '';
        $success = true;

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
        } catch (\Throwable $e) {
            $success = false;
            $output = $e->getMessage();
        }

        return view('admin.migration-runner', [
            'active' => 'admin-settings',
            'output' => $output,
            'success' => $success,
        ]);
    }

    /**
     * Internal JSON Fallback helpers for zero-downtime hosting resilience.
     */
    protected function loadOffersFromJson(): \Illuminate\Support\Collection
    {
        $file = storage_path('app/offers.json');
        if (! File::exists($file)) {
            return collect();
        }

        try {
            $data = json_decode(File::get($file), true);

            return collect(is_array($data) ? $data : [])->map(function ($item, $idx) {
                $m = new Offer($item);
                $m->id = $item['id'] ?? ($idx + 1);

                return $m;
            });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function saveOfferToJson(array $offerData): void
    {
        try {
            $file = storage_path('app/offers.json');
            File::ensureDirectoryExists(dirname($file));
            $existing = File::exists($file) ? json_decode(File::get($file), true) : [];
            if (! is_array($existing)) {
                $existing = [];
            }
            $offerData['id'] = count($existing) + 1;
            $existing[] = $offerData;
            File::put($file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            // Ignore
        }
    }

    protected function loadCouponsFromJson(): \Illuminate\Support\Collection
    {
        $file = storage_path('app/coupons.json');
        if (! File::exists($file)) {
            return collect();
        }

        try {
            $data = json_decode(File::get($file), true);

            return collect(is_array($data) ? $data : [])->map(function ($item, $idx) {
                $m = new Coupon($item);
                $m->id = $item['id'] ?? ($idx + 1);

                return $m;
            });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function saveCouponToJson(array $couponData): void
    {
        try {
            $file = storage_path('app/coupons.json');
            File::ensureDirectoryExists(dirname($file));
            $existing = File::exists($file) ? json_decode(File::get($file), true) : [];
            if (! is_array($existing)) {
                $existing = [];
            }
            $couponData['id'] = count($existing) + 1;
            $existing[] = $couponData;
            File::put($file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            // Ignore
        }
    }

    protected function updateOfferStatusInJson($id, string $newStatus): ?string
    {
        try {
            $file = storage_path('app/offers.json');
            if (! File::exists($file)) return null;
            $offers = json_decode(File::get($file), true);
            if (! is_array($offers)) return null;

            $title = null;
            foreach ($offers as &$o) {
                if (($o['id'] ?? '') == $id) {
                    $o['status'] = $newStatus;
                    $title = $o['title'] ?? null;
                    break;
                }
            }
            File::put($file, json_encode($offers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $title;
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function stopOfferInJson($id): ?string
    {
        try {
            $file = storage_path('app/offers.json');
            if (! File::exists($file)) return null;
            $offers = json_decode(File::get($file), true);
            if (! is_array($offers)) return null;

            $title = null;
            foreach ($offers as &$o) {
                if (($o['id'] ?? '') == $id) {
                    $o['status'] = 'expired';
                    $o['ends_at'] = Carbon::now('Asia/Kolkata')->toDateTimeString();
                    $title = $o['title'] ?? null;
                    break;
                }
            }
            File::put($file, json_encode($offers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $title;
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function deleteOfferFromJson($id): ?string
    {
        try {
            $file = storage_path('app/offers.json');
            if (! File::exists($file)) return null;
            $offers = json_decode(File::get($file), true);
            if (! is_array($offers)) return null;

            $title = null;
            $filtered = [];
            foreach ($offers as $o) {
                if (($o['id'] ?? '') == $id) {
                    $title = $o['title'] ?? null;
                } else {
                    $filtered[] = $o;
                }
            }
            File::put($file, json_encode(array_values($filtered), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $title;
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function updateCouponStatusInJson($id, string $newStatus): ?string
    {
        try {
            $file = storage_path('app/coupons.json');
            if (! File::exists($file)) return null;
            $coupons = json_decode(File::get($file), true);
            if (! is_array($coupons)) return null;

            $code = null;
            foreach ($coupons as &$c) {
                if (($c['id'] ?? '') == $id) {
                    $c['status'] = $newStatus;
                    $code = $c['code'] ?? null;
                    break;
                }
            }
            File::put($file, json_encode($coupons, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $code;
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function deleteCouponFromJson($id): ?string
    {
        try {
            $file = storage_path('app/coupons.json');
            if (! File::exists($file)) return null;
            $coupons = json_decode(File::get($file), true);
            if (! is_array($coupons)) return null;

            $code = null;
            $filtered = [];
            foreach ($coupons as $c) {
                if (($c['id'] ?? '') == $id) {
                    $code = $c['code'] ?? null;
                } else {
                    $filtered[] = $c;
                }
            }
            File::put($file, json_encode(array_values($filtered), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $code;
        } catch (\Throwable $e) {
            return null;
        }
    }
}

