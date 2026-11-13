<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCourse;
use App\Services\CashfreeService;
use App\Services\CommissionService;
use App\Services\EmailNotificationService;
use App\Services\PackageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CashfreePaymentController extends Controller
{
    /**
     * Initiate Cashfree Online Payment from Checkout (/buy-now).
     * Creates or prepares the student order and requests a payment_session_id from Cashfree.
     */
    public function initiatePayment(Request $request): JsonResponse|RedirectResponse|View
    {
        $authUser = Auth::user();

        $request->validate([
            'name' => [$authUser ? 'nullable' : 'required', 'string', 'max:255'],
            'email' => [$authUser ? 'nullable' : 'required', 'email', 'max:255'],
            'phone' => [$authUser ? 'nullable' : 'required', 'string', 'max:20'],
            'password' => [$authUser ? 'nullable' : 'required', 'string', 'min:6'],
            'package' => ['required', 'string'],
            'referral_code' => ['nullable', 'string', 'max:100'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
        ]);

        $name = trim((string) ($request->input('name') ?: $authUser?->name));
        $phone = trim((string) ($request->input('phone') ?: $authUser?->phone));
        $email = strtolower(trim((string) ($request->input('email') ?: $authUser?->email)));
        $password = (string) $request->input('password');
        $packageKey = strtolower(trim((string) $request->input('package', 'advance')));
        $referralCode = trim((string) $request->input('referral_code', ''));

        if (empty($referralCode)) {
            $referralCode = $authUser?->sponsor_id ?? 'SKL-ADMIN';
        }

        // Verify sponsor affiliate ID
        $sponsor = User::where('affiliate_id', $referralCode)
            ->orWhere('email', $referralCode)
            ->orWhere('phone', $referralCode)
            ->first();
        $sponsorId = $sponsor ? ($sponsor->affiliate_id ?? $referralCode) : 'SKL-ADMIN';

        $pkg = CommissionService::getPackageInfo($packageKey);
        $packageName = $pkg['name'];
        $packagePrice = (float) $pkg['price'];

        // 1. Calculate optional coupon discount
        $couponCode = strtoupper(trim((string) $request->input('coupon_code', '')));
        $couponDiscount = 0;
        if (! empty($couponCode)) {
            $couponCheck = PackageService::validateCoupon($couponCode, $packageKey, $packagePrice, $email);
            if (! empty($couponCheck['valid'])) {
                $couponDiscount = (float) $couponCheck['discount_amount'];
            }
        }

        // 2. Calculate Differential Upgrade or New Enrollment Pricing
        $isUpgrade = false;
        $payableAmount = $packagePrice;
        $targetUser = $authUser;

        if ($authUser && ($authUser->email === $email || empty($request->input('email')))) {
            $upgrade = CommissionService::getUpgradeDetails($authUser->active_package, $packageKey);

            if ($upgrade['is_current']) {
                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => "Aap pehle se {$packageName} par hain."], 422)
                    : back()->withInput()->with('error', "Aap pehle se {$packageName} par hain.");
            }

            if ($upgrade['is_lower']) {
                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => "Aapka vartaman package ({$authUser->active_package}) is se uncha hai."], 422)
                    : back()->withInput()->with('error', "Aapka vartaman package ({$authUser->active_package}) is se uncha hai.");
            }

            $isUpgrade = true;
            $payableAmount = $upgrade['payable_price'];
        } else {
            // Guest checkout: Check if email already exists
            $existing = User::where('email', $email)->first();
            if ($existing) {
                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => 'Is email ke sath account pehle se maujood hai. Kripya pehle Login karein!'], 422)
                    : back()->withInput()->with('error', 'Is email ke sath account pehle se maujood hai. Kripya pehle Login karein!');
            }

            // Create pending user account
            $affiliateId = 'SKL-'.rand(1000, 9999);
            while (User::where('affiliate_id', $affiliateId)->exists()) {
                $affiliateId = 'SKL-'.rand(1000, 9999);
            }

            $targetUser = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'affiliate_id' => $affiliateId,
                'sponsor_id' => $sponsorId,
                'active_package' => $packageName,
                'payment_status' => 'pending', // Activated on successful Cashfree payment
                'wallet_balance' => 0.00,
                'today_earning' => 0.00,
                'weekly_earning' => 0.00,
                'monthly_earning' => 0.00,
                'total_earning' => 0.00,
                'passive_earning' => 0.00,
                'kyc_status' => 'Pending Verification',
                'role' => 'affiliate',
            ]);
        }

        // Apply coupon discount on final payable amount
        if ($couponDiscount > 0) {
            $payableAmount = max(0, $payableAmount - $couponDiscount);
        }

        // Generate clean Cashfree Order ID (alphanumeric + underscore)
        $orderId = 'SKL_'.date('ymd').'_'.$targetUser->id.'_'.rand(1000, 9999);

        // Save order details in session
        $orderData = [
            'order_id' => $orderId,
            'user_id' => $targetUser->id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'package_slug' => $packageKey,
            'package_name' => $packageName,
            'amount' => $payableAmount,
            'original_amount' => $packagePrice,
            'coupon_code' => $couponCode ?: null,
            'coupon_discount' => $couponDiscount,
            'is_upgrade' => $isUpgrade,
            'sponsor_id' => $targetUser->sponsor_id ?? $sponsorId,
            'payment_method' => 'cashfree',
            'created_at' => now()->toDateTimeString(),
        ];
        session(['pending_cashfree_order' => $orderData]);
        session(['last_order' => $orderData]);

        // Record or update Order in database for Admin tracking
        $dbOrder = Order::updateOrCreate([
            'order_id' => $orderId,
        ], [
            'user_id' => $targetUser->id,
            'buyer_name' => $name,
            'buyer_email' => $email,
            'buyer_phone' => $phone,
            'sponsor_id' => $targetUser->sponsor_id ?? $sponsorId,
            'package_name' => $packageName,
            'package_slug' => $packageKey,
            'amount' => $payableAmount,
            'original_amount' => $packagePrice,
            'coupon_code' => $couponCode ?: null,
            'coupon_discount' => $couponDiscount,
            'payment_method' => 'cashfree',
            'payment_status' => 'pending',
        ]);
        $orderData['db_order_id'] = $dbOrder->id;

        // Call Cashfree PG Order API
        $cfOrder = CashfreeService::createOrder([
            'order_id' => $orderId,
            'order_amount' => $payableAmount,
            'customer_id' => 'USER_'.$targetUser->id,
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'order_note' => "SkillLearner Enrollment: {$packageName}",
            'return_url' => url('/payment/cashfree/callback?order_id={order_id}'),
            'notify_url' => url('/payment/cashfree/webhook'),
        ]);

        if (! $cfOrder['success']) {
            Log::warning('💳 [CASHFREE-GATEWAY] Initiate order failed: '.($cfOrder['error'] ?? 'Unknown'));

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $cfOrder['error'] ?? 'Cashfree Order Failed',
                    'fallback_url' => url('/payment-status'),
                ], 400);
            }

            return redirect('/payment-status')->with('error', 'Online payment gateway connection issue: '.($cfOrder['error'] ?? 'Please use UPI / QR transfer below.'));
        }

        $paymentSessionId = $cfOrder['payment_session_id'];

        Log::info("💳 [CASHFREE-GATEWAY] Live checkout rendered for Order #{$orderId} | Session: {$paymentSessionId}");

        $activeEnv = CashfreeService::getEnv();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'payment_session_id' => $paymentSessionId,
                'order_id' => $orderId,
                'environment' => $activeEnv,
            ]);
        }

        // Render official Cashfree payment checkout bridge
        return view('payment.cashfree-checkout', [
            'paymentSessionId' => $paymentSessionId,
            'orderId' => $orderId,
            'order' => $orderData,
            'environment' => $activeEnv,
        ]);
    }

    /**
     * Handle Cashfree Return Callback (Customer redirected after completing payment).
     */
    public function handleCallback(Request $request): RedirectResponse
    {
        $orderId = (string) $request->query('order_id', '');
        $simStatus = (string) $request->query('sim_status', '');

        if (empty($orderId)) {
            Log::warning('💳 [CASHFREE-GATEWAY] Callback received without order_id query param');

            return redirect('/buy-now')->with('error', 'Invalid payment return request (Order ID missing).');
        }

        // Handle simulation override if passed from test simulator
        if (! empty($simStatus)) {
            session(['simulated_order_status_'.$orderId => strtoupper($simStatus)]);
        }

        Log::info('================================================================================');
        Log::info("💳 [CASHFREE-GATEWAY] 📥 PAYMENT RETURN CALLBACK RECEIVED for Order #{$orderId}");

        // Check payment status from Cashfree or Simulator
        $orderStatusInfo = CashfreeService::getOrder($orderId);

        if (! $orderStatusInfo['success']) {
            Log::error("💳 [CASHFREE-GATEWAY] Verification failed for Order #{$orderId}: ".($orderStatusInfo['error'] ?? 'Unknown error'));

            return redirect('/payment-status')->with('error', 'Unable to verify payment with Cashfree: '.($orderStatusInfo['error'] ?? 'Please check status.'));
        }

        $status = strtoupper((string) ($orderStatusInfo['order_status'] ?? 'PENDING'));
        Log::info("💳 [CASHFREE-GATEWAY] Order status verified: '{$status}'");

        if ($status === 'PAID') {
            Log::info("💳 [CASHFREE-GATEWAY] ✅ Payment Status is PAID for Order #{$orderId}! Finalizing enrollment...");
            $this->finalizePaidOrder($orderId, $orderStatusInfo);

            return redirect('/payment-status')->with('success', '🎉 Many Congratulations! Aapka payment Cashfree dwara successfully verify ho gaya hai. Aapka account active ho chuka hai!');
        }

        if (in_array($status, ['FAILED', 'CANCELLED', 'USER_DROPPED'])) {
            Log::warning("💳 [CASHFREE-GATEWAY] ❌ Payment {$status} for Order #{$orderId}");

            // Update database order as failed for tracking
            Order::where('order_id', $orderId)->update([
                'payment_status' => 'failed',
                'failure_reason' => $status,
                'gateway_payload' => $orderStatusInfo,
            ]);

            // Update session order status to Failed so payment status page displays retry
            $order = session('last_order', []);
            $order['status'] = 'Failed';
            session(['last_order' => $order]);

            return redirect('/payment-status')->with('error', "Payment status: {$status}. Kripya dobara payment karein ya UPI transfer karein.");
        }

        Log::info("💳 [CASHFREE-GATEWAY] ⏳ Payment status pending: {$status}");

        return redirect('/payment-status')->with('info', "Payment processing me hai (Status: {$status}). Kuch pal baad page refresh karein.");
    }

    /**
     * Handle Server-to-Server Cashfree Webhook Notifications.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = (string) $request->header('x-webhook-signature', '');
        $timestamp = (string) $request->header('x-webhook-timestamp', '');
        $rawBody = (string) $request->getContent();

        // Verify webhook signature
        if (! CashfreeService::verifyWebhookSignature($rawBody, $signature, $timestamp)) {
            Log::warning('Cashfree Webhook Signature Mismatch');

            return response()->json(['status' => 'invalid_signature'], 400);
        }

        $payload = $request->json()->all();
        $eventType = $payload['type'] ?? '';
        $data = $payload['data'] ?? [];
        $order = $data['order'] ?? [];
        $orderId = $order['order_id'] ?? '';
        $orderStatus = strtoupper((string) ($order['order_status'] ?? ''));

        if (in_array($eventType, ['PAYMENT_SUCCESS_WEBHOOK', 'ORDER_PAID_WEBHOOK']) || $orderStatus === 'PAID') {
            if (! empty($orderId)) {
                $this->finalizePaidOrder($orderId, $data);
            }
        }

        return response()->json(['status' => 'processed']);
    }

    /**
     * Finalize and activate an order upon verified payment success.
     */
    protected function finalizePaidOrder(string $orderId, array $paymentDetails = []): void
    {
        $sessionOrder = session('pending_cashfree_order');
        $userId = $sessionOrder['user_id'] ?? null;
        $user = $userId ? User::find($userId) : null;

        // If not in session, resolve user from Order ID pattern (SKL_yymmdd_USERID_xxxx)
        if (! $user && preg_match('/SKL_\d+_(\d+)_\d+/', $orderId, $matches)) {
            $user = User::find((int) $matches[1]);
        }

        if (! $user) {
            Log::error("Cashfree: Could not locate user for paid Order {$orderId}");

            return;
        }

        // Prevent duplicate activation
        if ($user->payment_status === 'paid' && $user->userCourses()->count() > 0) {
            return;
        }

        $packageName = $sessionOrder['package_name'] ?? $user->active_package;

        Log::info("💳 [CASHFREE-GATEWAY] 👤 Activating User: #{$user->id} - {$user->name} ({$user->email})");
        Log::info("💳 [CASHFREE-GATEWAY] 📦 Setting Active Package: {$packageName}");

        // 1. Activate user account
        $user->update([
            'payment_status' => 'paid',
            'active_package' => $packageName,
        ]);

        // 2. Unlock all package courses with 0% progress
        $courses = Course::all();
        foreach ($courses as $c) {
            UserCourse::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $c->id,
            ], [
                'progress_percent' => 0,
            ]);
        }
        Log::info('💳 [CASHFREE-GATEWAY] 🔓 Unlocked '.count($courses)." courses for User #{$user->id}");

        // 3. Distribute 2-Tier commissions in Credited status immediately
        $sponsorId = $user->sponsor_id ?? 'SL-ADMIN';
        Log::info("💳 [CASHFREE-GATEWAY] 💰 Processing 2-Tier commissions for Sponsor: {$sponsorId}");
        CommissionService::processSale(
            $packageName,
            $user->name,
            $sponsorId,
            $user,
            initialStatus: 'Credited'
        );
        Log::info('💳 [CASHFREE-GATEWAY] ✅ Commissions successfully calculated and credited to sponsor wallet!');

        // 4. Send branded welcome email notification
        try {
            EmailNotificationService::sendAccountCreated($user, $packageName);
            Log::info("💳 [CASHFREE-GATEWAY] 📧 Welcome email sent to {$user->email}");
        } catch (\Throwable $e) {
            Log::warning('Email dispatch failed after Cashfree payment: '.$e->getMessage());
        }

        // 5. Update database order record & generate invoice number
        $dbOrder = Order::where('order_id', $orderId)->first();
        if ($dbOrder) {
            $invNumber = $dbOrder->invoice_number ?: ('INV-SKL-'.date('Y').'-'.str_pad((string) $dbOrder->id, 5, '0', STR_PAD_LEFT));
            $dbOrder->update([
                'payment_status' => 'paid',
                'transaction_id' => $orderId,
                'invoice_number' => $invNumber,
                'gateway_payload' => $paymentDetails,
            ]);
            Log::info("💳 [CASHFREE-GATEWAY] 🧾 Tax Invoice generated: {$invNumber} for Order #{$orderId}");
        }

        // 6. Update session order data
        $finalOrder = array_merge($sessionOrder ?? [], [
            'order_id' => $orderId,
            'status' => 'Credited',
            'payment_method' => 'cashfree',
            'transaction_id' => $orderId,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'invoice_number' => $dbOrder?->invoice_number ?? null,
        ]);
        session(['last_order' => $finalOrder]);

        // 7. Auto-login the user if not currently logged in as super admin
        if (! Auth::check() || Auth::id() === $user->id) {
            Auth::login($user);
            session()->regenerate();
            session(['user' => $user->toArray()]);
        }
    }
}
