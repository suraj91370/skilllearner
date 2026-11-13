<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isSimulated ? 'Cashfree Payment Gateway (Test Sandbox)' : 'Connecting to Secure Payment Gateway' }} | SkillLearner</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @if(!$isSimulated)
        <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    @endif
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0a0f1d 0%, #032a24 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            color: #ffffff;
        }
        .checkout-wrapper {
            max-width: 520px;
            width: 100%;
            background: #ffffff;
            color: #0f172a;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.25);
            overflow: hidden;
            position: relative;
        }
        /* Cashfree Header Bar */
        .gateway-header {
            background: #0f172a;
            color: #ffffff;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #05B396;
        }
        .gateway-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-logo-img {
            max-height: 38px;
            width: auto;
            background: #ffffff;
            padding: 3px 8px;
            border-radius: 8px;
        }
        .cf-badge {
            background: #5e17eb;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .cf-badge.sim-badge {
            background: #05B396;
        }

        .checkout-body {
            padding: 1.8rem 1.6rem 2rem;
        }

        /* Order Summary Pill */
        .order-summary-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.2rem;
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .order-row:last-child {
            margin-bottom: 0;
            padding-top: 8px;
            border-top: 1px dashed #cbd5e1;
        }

        /* Sandbox Notice Banner */
        .sandbox-notice {
            background: #f0fdf4;
            border: 1.5px dashed #05B396;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 1.4rem;
            font-size: 0.85rem;
            color: #065f46;
            line-height: 1.5;
        }

        /* Payment Option Tabs */
        .payment-tabs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 1.2rem;
        }
        .tab-btn {
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            padding: 10px 8px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #475569;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease;
        }
        .tab-btn.active {
            background: #f0fdfa;
            border-color: #05B396;
            color: #0f172a;
            box-shadow: 0 2px 8px rgba(5, 179, 150, 0.15);
        }

        /* Tab Content Panels */
        .tab-content {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 1.5rem;
        }

        .upi-app-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 10px;
        }
        .upi-app-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 4px;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #334155;
            background: #f8fafc;
        }

        /* Main Buttons */
        .btn-pay-success {
            width: 100%;
            background: #05B396;
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-pay-success:hover {
            background: #048873;
            transform: translateY(-2px);
        }
        .btn-pay-fail {
            width: 100%;
            background: transparent;
            color: #dc2626;
            border: 1.5px solid #fecaca;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.2s ease;
        }
        .btn-pay-fail:hover {
            background: #fef2f2;
            border-color: #ef4444;
        }
        .btn-cancel-link {
            display: block;
            text-align: center;
            margin-top: 12px;
            color: #64748b;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-cancel-link:hover {
            color: #0f172a;
            text-decoration: underline;
        }

        /* Spinner */
        .spinner {
            width: 44px;
            height: 44px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #05B396;
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
            margin: 1.5rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .processing-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.96);
            z-index: 50;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="checkout-wrapper">
        <!-- Gateway Header -->
        <div class="gateway-header">
            <div class="gateway-brand">
                <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" class="brand-logo-img" onerror="this.src='/images/logo.png';">
            </div>
            <div class="cf-badge {{ $isSimulated ? 'sim-badge' : '' }}">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>{{ $isSimulated ? 'LOCAL TEST GATEWAY' : 'CASHFREE PG' }}</span>
            </div>
        </div>

        <!-- Processing Modal Overlay -->
        <div class="processing-overlay" id="processingOverlay">
            <div class="spinner"></div>
            <h3 style="font-weight: 800; color: #0f172a; font-size: 1.2rem; margin-bottom: 6px;" id="processingTitle">Processing Payment...</h3>
            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5;" id="processingSubtitle">Communicating with payment gateway and recording in storage/logs/laravel.log...</p>
        </div>

        <div class="checkout-body">

            @if($isSimulated)
                {{-- ============================================================== --}}
                {{-- MODE A: LOCAL TEST SIMULATOR (No Live Money Charged)          --}}
                {{-- ============================================================== --}}
                
                <!-- Notice Banner -->
                <div class="sandbox-notice">
                    <div style="font-weight: 800; margin-bottom: 3px; display: flex; align-items: center; gap: 6px;">
                        <span>🧪</span> <strong>Local Sandbox Mode Active</strong>
                    </div>
                    <div>
                        Cashfree API keys empty hain to local simulation mode active hai. Aap payment flow bina real paise kate test kar sakte hain. Subah/Shaam har step <code>storage/logs/laravel.log</code> me log ho raha hai.
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary-box">
                    <div class="order-row">
                        <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Order ID</span>
                        <span style="font-size: 0.88rem; color: #0f172a; font-weight: 800;">#{{ $orderId }}</span>
                    </div>
                    <div class="order-row">
                        <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Package</span>
                        <span style="font-size: 0.88rem; color: #05B396; font-weight: 800;">{{ $order['package_name'] ?? 'Course Package' }}</span>
                    </div>
                    <div class="order-row">
                        <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Customer</span>
                        <span style="font-size: 0.85rem; color: #0f172a; font-weight: 700;">{{ $order['name'] ?? 'Student' }} ({{ $order['phone'] ?? '' }})</span>
                    </div>
                    <div class="order-row">
                        <span style="font-size: 0.92rem; color: #0f172a; font-weight: 800;">Total Payable</span>
                        <span style="font-size: 1.35rem; color: #05B396; font-weight: 900;">₹{{ number_format($order['amount'] ?? 0) }}</span>
                    </div>
                </div>

                <!-- Payment Method Tabs -->
                <div class="payment-tabs">
                    <div class="tab-btn active" id="tabUpi" onclick="switchTab('upi')">📲 UPI / QR</div>
                    <div class="tab-btn" id="tabCard" onclick="switchTab('card')">💳 Test Card</div>
                    <div class="tab-btn" id="tabNb" onclick="switchTab('nb')">🏦 Net Banking</div>
                </div>

                <!-- Tab Panel 1: UPI -->
                <div class="tab-content" id="panelUpi">
                    <div style="font-size: 0.84rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Pay with any UPI App:</div>
                    <div style="font-size: 0.78rem; color: #64748b; margin-bottom: 8px;">Scan with Google Pay, PhonePe, Paytm, or enter UPI ID</div>
                    <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 10px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-family: monospace; font-size: 0.85rem; color: #334155; font-weight: 600;">student@okhdfcbank</span>
                        <span style="background: #e2e8f0; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Verified</span>
                    </div>
                    <div class="upi-app-grid">
                        <div class="upi-app-item">🟢 GPay</div>
                        <div class="upi-app-item">🟣 PhonePe</div>
                        <div class="upi-app-item">🔵 Paytm</div>
                        <div class="upi-app-item">🟡 CRED</div>
                    </div>
                </div>

                <!-- Tab Panel 2: Card (Hidden by default) -->
                <div class="tab-content" id="panelCard" style="display: none;">
                    <div style="font-size: 0.84rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Simulated Sandbox Card:</div>
                    <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; font-size: 0.85rem; color: #334155;">
                        <div style="font-weight: 700; font-family: monospace; margin-bottom: 4px;">4111 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 1111</div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #64748b;">
                            <span>Exp: 12/28</span>
                            <span>CVV: 123</span>
                            <span>OTP: 123456</span>
                        </div>
                    </div>
                </div>

                <!-- Tab Panel 3: Net Banking (Hidden by default) -->
                <div class="tab-content" id="panelNb" style="display: none;">
                    <div style="font-size: 0.84rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Simulated Banks:</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 0.8rem; font-weight: 700;">
                        <div style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; text-align: center;">HDFC Bank</div>
                        <div style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; text-align: center;">State Bank of India</div>
                        <div style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; text-align: center;">ICICI Bank</div>
                        <div style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; text-align: center;">Axis Bank</div>
                    </div>
                </div>

                <!-- Simulation Action Buttons -->
                <button type="button" class="btn-pay-success" id="btnSimulateSuccess" onclick="executeSimulatedPayment('PAID')">
                    <span>⚡ Pay ₹{{ number_format($order['amount'] ?? 0) }} (Simulate Payment Success)</span>
                </button>

                <button type="button" class="btn-pay-fail" id="btnSimulateFail" onclick="executeSimulatedPayment('FAILED')">
                    <span>❌ Simulate Payment Failure / Decline</span>
                </button>

                <a href="{{ url('/buy-now') }}" class="btn-cancel-link">
                    &larr; Cancel and Return to Checkout
                </a>

            @else
                {{-- ============================================================== --}}
                {{-- MODE B: LIVE CASHFREE DROP CHECKOUT (Official JS SDK v3)      --}}
                {{-- ============================================================== --}}
                <div class="spinner" id="paymentSpinner"></div>

                <h1 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; text-align: center;" id="statusTitle">
                    Connecting to Cashfree...
                </h1>
                <p style="font-size: 0.9rem; color: #64748b; line-height: 1.5; margin-bottom: 1.5rem; text-align: center;" id="statusDesc">
                    Please wait while we redirect you to the secure payment screen. Do not refresh or press back.
                </p>

                <div class="order-summary-box">
                    <div class="order-row">
                        <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Package</span>
                        <span style="font-size: 0.88rem; color: #0f172a; font-weight: 800;">{{ $order['package_name'] ?? 'Course Package' }}</span>
                    </div>
                    <div class="order-row">
                        <span style="font-size: 0.92rem; color: #0f172a; font-weight: 800;">Total Payable</span>
                        <span style="font-size: 1.35rem; color: #05B396; font-weight: 900;">₹{{ number_format($order['amount'] ?? 0) }}</span>
                    </div>
                </div>

                <div id="fallbackAction" style="display: none; margin-top: 1.2rem; text-align: center;">
                    <p style="font-size: 0.85rem; color: #dc2626; margin-bottom: 0.5rem;">Payment window did not open?</p>
                    <button onclick="triggerCashfreeSelf()" class="btn-pay-success" style="display: inline-block; width: auto; padding: 10px 24px;">Click Here to Pay (Full Screen)</button>
                    <br>
                    <a href="{{ url('/buy-now') }}" class="btn-cancel-link">Return to Checkout</a>
                </div>
            @endif

        </div>
    </div>

    <script>
        const isSimulated = @json($isSimulated);
        const orderId = @json($orderId);
        const paymentSessionId = @json($paymentSessionId);
        const cashfreeMode = @json($environment === 'production' ? 'production' : 'sandbox');

        // Tab Switcher for Sandbox
        function switchTab(tab) {
            const tabs = ['upi', 'card', 'nb'];
            tabs.forEach(t => {
                const tabEl = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
                const panelEl = document.getElementById('panel' + t.charAt(0).toUpperCase() + t.slice(1));
                if (tabEl) tabEl.classList.remove('active');
                if (panelEl) panelEl.style.display = 'none';
            });

            const activeTab = document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1));
            const activePanel = document.getElementById('panel' + tab.charAt(0).toUpperCase() + tab.slice(1));
            if (activeTab) activeTab.classList.add('active');
            if (activePanel) activePanel.style.display = 'block';
        }

        // Simulated Payment Execution
        function executeSimulatedPayment(targetStatus) {
            const overlay = document.getElementById('processingOverlay');
            const title = document.getElementById('processingTitle');
            const subtitle = document.getElementById('processingSubtitle');

            if (overlay) overlay.style.display = 'flex';

            if (targetStatus === 'PAID') {
                if (title) title.innerText = '⚡ Payment Approved (Test Mode)';
                if (subtitle) subtitle.innerText = 'Writing log to storage/logs/laravel.log & activating courses...';
            } else {
                if (title) title.innerText = '❌ Payment Declined (Test Mode)';
                if (subtitle) subtitle.innerText = 'Redirecting to checkout status with failure notice...';
            }

            setTimeout(function() {
                const callbackUrl = "{{ route('payment.cashfree.callback') }}?order_id=" + encodeURIComponent(orderId) + "&sim_status=" + encodeURIComponent(targetStatus);
                window.location.href = callbackUrl;
            }, 800);
        }

        // Live Cashfree Checkout
        @if(!$isSimulated)
        let cashfree = null;

        function triggerCashfreeCheckout() {
            try {
                if (!cashfree) {
                    cashfree = Cashfree({ mode: cashfreeMode });
                }

                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_modal"
                }).then(function(result) {
                    if (result && result.error) {
                        console.warn("Cashfree checkout modal notice:", result.error);
                    }
                    // Redirect to callback using current browser host
                    const callbackUrl = "{{ route('payment.cashfree.callback') }}?order_id=" + encodeURIComponent(orderId);
                    window.location.href = callbackUrl;
                }).catch(function(err) {
                    console.error("Modal failed, opening full-screen checkout:", err);
                    triggerCashfreeSelf();
                });
            } catch (err) {
                console.error("Cashfree Checkout Error:", err);
                document.getElementById('statusTitle').innerText = "Action Required";
                document.getElementById('statusDesc').innerText = "Please click below to complete your payment securely on Cashfree.";
                document.getElementById('fallbackAction').style.display = 'block';
            }
        }

        function triggerCashfreeSelf() {
            try {
                if (!cashfree) {
                    cashfree = Cashfree({ mode: cashfreeMode });
                }
                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_self"
                });
            } catch (err) {
                console.error("Direct redirect failed:", err);
                alert("Unable to open Cashfree. Please refresh and try again.");
            }
        }

        window.addEventListener('load', function() {
            setTimeout(triggerCashfreeCheckout, 600);
            setTimeout(function() {
                const fallback = document.getElementById('fallbackAction');
                if (fallback) fallback.style.display = 'block';
            }, 3500);
        });
        @endif
    </script>
</body>
</html>
