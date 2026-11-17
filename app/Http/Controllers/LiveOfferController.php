<?php

namespace App\Http\Controllers;

use App\Models\LiveOffer;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LiveOfferController extends Controller
{
    /**
     * User / Student / Affiliate Portal: View Live Offers
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleOffers();

        $offers = LiveOffer::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

        return view('portal.live-offers', [
            'offers' => $offers,
            'active' => 'live-offers',
        ]);
    }

    /**
     * Download Live Offer Poster
     */
    public function download(LiveOffer $liveOffer): BinaryFileResponse|RedirectResponse
    {
        $liveOffer->increment('download_count');

        if (! empty($liveOffer->poster)) {
            $fullPath = public_path($liveOffer->poster);
            if (file_exists($fullPath)) {
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                $downloadName = Str::slug($liveOffer->title).'-offer-poster.'.$extension;

                return response()->download($fullPath, $downloadName);
            }
        }

        if (! empty($liveOffer->poster_url)) {
            return redirect()->away($liveOffer->poster_url);
        }

        return back()->with('error', 'Poster file not found on server.');
    }

    /**
     * Admin Panel: Manage Live Offers
     */
    public function adminIndex(Request $request): View
    {
        $this->ensureSampleOffers();

        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = LiveOffer::query()->orderBy('sort_order', 'asc')->latest();

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'hidden') {
            $query->where('is_active', false);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%")
                    ->orWhere('prize', 'like', "%{$search}%")
                    ->orWhere('target_criteria', 'like', "%{$search}%");
            });
        }

        $offers = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => LiveOffer::count(),
            'active' => LiveOffer::where('is_active', true)->count(),
            'hidden' => LiveOffer::where('is_active', false)->count(),
            'downloads' => (int) LiveOffer::sum('download_count'),
        ];

        return view('admin.live-offers', compact('offers', 'counts', 'statusFilter', 'search'));
    }

    /**
     * Store new live offer with poster upload
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'poster_url' => 'nullable|url|max:500',
            'badge' => 'nullable|string|max:50',
            'prize' => 'nullable|string|max:255',
            'target_criteria' => 'nullable|string|max:255',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $folder = 'uploads/live_offers/posters';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'offer_poster_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);
            $posterPath = $folder.'/'.$filename;
        }

        LiveOffer::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'poster' => $posterPath,
            'poster_url' => $validated['poster_url'] ?? null,
            'badge' => ! empty($validated['badge']) ? strtoupper(trim($validated['badge'])) : 'LIVE OFFER',
            'prize' => $validated['prize'] ?? null,
            'target_criteria' => $validated['target_criteria'] ?? null,
            'starts_at' => $validated['starts_at'] ?? Carbon::now(),
            'ends_at' => $validated['ends_at'] ?? null,
            'description' => $validated['description'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : (LiveOffer::max('sort_order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.live-offers')->with('success', 'Live Offer & Contest created successfully with poster!');
    }

    /**
     * Update live offer
     */
    public function update(Request $request, LiveOffer $liveOffer): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'poster_url' => 'nullable|url|max:500',
            'badge' => 'nullable|string|max:50',
            'prize' => 'nullable|string|max:255',
            'target_criteria' => 'nullable|string|max:255',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $posterPath = $liveOffer->poster;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $folder = 'uploads/live_offers/posters';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'offer_poster_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);

            // Clean up old file if exists
            if (! empty($liveOffer->poster) && file_exists(public_path($liveOffer->poster))) {
                @unlink(public_path($liveOffer->poster));
            }

            $posterPath = $folder.'/'.$filename;
        }

        $liveOffer->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'poster' => $posterPath,
            'poster_url' => $validated['poster_url'] ?? $liveOffer->poster_url,
            'badge' => ! empty($validated['badge']) ? strtoupper(trim($validated['badge'])) : $liveOffer->badge,
            'prize' => $validated['prize'] ?? null,
            'target_criteria' => $validated['target_criteria'] ?? null,
            'starts_at' => $validated['starts_at'] ?? $liveOffer->starts_at,
            'ends_at' => $validated['ends_at'] ?? $liveOffer->ends_at,
            'description' => $validated['description'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : $liveOffer->sort_order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.live-offers')->with('success', 'Live Offer updated successfully!');
    }

    /**
     * Toggle active/hidden
     */
    public function toggleStatus(LiveOffer $liveOffer): RedirectResponse
    {
        $liveOffer->update([
            'is_active' => ! $liveOffer->is_active,
        ]);

        $status = $liveOffer->is_active ? 'active and live' : 'hidden';

        return back()->with('success', "Live Offer '{$liveOffer->title}' is now {$status}.");
    }

    /**
     * Delete live offer
     */
    public function destroy(LiveOffer $liveOffer): RedirectResponse
    {
        $title = $liveOffer->title;

        if (! empty($liveOffer->poster) && file_exists(public_path($liveOffer->poster))) {
            @unlink(public_path($liveOffer->poster));
        }

        $liveOffer->delete();

        return redirect()->route('admin.live-offers')->with('success', "Live Offer '{$title}' deleted successfully!");
    }

    /**
     * Seed initial sample offers if table is empty
     */
    private function ensureSampleOffers(): void
    {
        if (LiveOffer::count() > 0) {
            return;
        }

        $now = Carbon::now();

        LiveOffer::create([
            'title' => 'Goa National Tour Contest 2026',
            'subtitle' => 'Exclusive 3 Nights & 4 Days Luxury Resort Trip sponsored by SkillLearner',
            'badge' => '🌴 GOA TRIP',
            'prize' => 'All-Expenses-Paid Goa Luxury Vacation + Flight Tickets',
            'target_criteria' => 'Achieve 50 Package Sales within the contest period',
            'poster_url' => 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=900&auto=format&fit=crop&q=80',
            'starts_at' => $now,
            'ends_at' => $now->copy()->addDays(30),
            'description' => 'Hit your monthly milestones to qualify for the grand national affiliate meet in Goa! Includes 5-star hotel stay, flight tickets, VIP awards night dinner, and mastermind sessions with top creators.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        LiveOffer::create([
            'title' => 'Mega Cash Bonus Bonanza — ₹25,000 Extra',
            'subtitle' => 'Special direct bank credit bonus for all top achieving affiliates this month',
            'badge' => '💰 CASH REWARD',
            'prize' => '₹25,000 Direct Cash Bonus to Bank Account',
            'target_criteria' => 'Cross ₹1,00,000 in monthly commission earnings',
            'poster_url' => 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=900&auto=format&fit=crop&q=80',
            'starts_at' => $now,
            'ends_at' => $now->copy()->addDays(20),
            'description' => 'Boost your momentum! Over and above your regular direct and passive commissions, receive a lump-sum cash reward of ₹25,000 straight to your verified bank account.',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
