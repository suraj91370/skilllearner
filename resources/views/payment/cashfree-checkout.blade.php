<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecting to Cashfree Payment Gateway | SkillLearner</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
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
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            color: #0f172a;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.25);
            overflow: hidden;
            position: relative;
        }
        .gateway-header {
            background: #0f172a;
            color: #ffffff;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #05B396;
        }
        .brand-logo-img {
            max-height: 38px;
            width: auto;
            background: #ffffff;
            padding: 3px 8px;
            border-radius: 8px;
        }
        .cf-badge {
            background: #05B396;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .checkout-body {
            padding: 2.2rem 1.8rem;
            text-align: center;
        }
        .spinner {
            width: 52px;
            height: 52px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #05B396;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0.5rem auto 1.5rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .order-summary-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.2rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .order-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
        }
        .btn-pay-now {
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-pay-now:hover {
            background: #048873;
            transform: translateY(-2px);
        }
        .btn-cancel-link {
            display: inline-block;
            margin-top: 14px;
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-cancel-link:hover {
            color: #0f172a;
            text-decoration: underline;
        }
        .security-badge {
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            color: #047857;
            font-weight: 700;
            background: #f0fdf9;
            border: 1px solid #a7f3d0;
            padding: 6px 14px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

    <div class="checkout-wrapper">
        <!-- Gateway Header -->
        <div class="gateway-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" class="brand-logo-img" onerror="this.src='/images/logo.png';">
            </div>
            <div class="cf-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>CASHFREE PG SECURE</span>
            </div>
        </div>

        <div class="checkout-body">
            <div class="spinner" id="paymentSpinner"></div>

            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;" id="statusTitle">
                Connecting to Cashfree...
            </h2>
            <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5;" id="statusDesc">
                Please wait while we redirect you to the official Cashfree payment gateway. Do not press back or refresh.
            </p>

            <!-- Order Summary -->
            <div class="order-summary-box">
                <div class="order-row">
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Order ID</span>
                    <span style="font-size: 0.88rem; color: #0f172a; font-weight: 800;">#{{ $orderId }}</span>
                </div>
                <div class="order-row">
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Package Selected</span>
                    <span style="font-size: 0.88rem; color: #05B396; font-weight: 800;">{{ $order['package_name'] ?? 'Course Package' }}</span>
                </div>
                <div class="order-row">
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">Customer</span>
                    <span style="font-size: 0.85rem; color: #0f172a; font-weight: 700;">{{ $order['name'] ?? 'Student' }}</span>
                </div>
                <div class="order-row">
                    <span style="font-size: 0.92rem; color: #0f172a; font-weight: 800;">Total Payable</span>
                    <span style="font-size: 1.35rem; color: #05B396; font-weight: 900;">₹{{ number_format($order['amount'] ?? 0) }}</span>
                </div>
            </div>

            <!-- Action Button -->
            <div id="actionContainer" style="margin-top: 1rem;">
                <button type="button" onclick="triggerCashfree()" class="btn-pay-now" id="btnPayNow">
                    <span>⚡ Pay ₹{{ number_format($order['amount'] ?? 0) }} on Cashfree</span>
                </button>
            </div>

            <div>
                <a href="{{ url('/buy-now') }}" class="btn-cancel-link">
                    &larr; Cancel and Return to Checkout
                </a>
            </div>

            <div class="security-badge">
                <span>🔒 256-Bit SSL Encrypted &bull; 100% RBI Compliant Gateway</span>
            </div>
        </div>
    </div>

    <script>
        const paymentSessionId = @json($paymentSessionId);
        const orderId = @json($orderId);
        const cashfreeMode = @json($environment === 'production' ? 'production' : 'sandbox');

        let cashfree = null;

        function triggerCashfree() {
            try {
                if (!cashfree) {
                    cashfree = Cashfree({ mode: cashfreeMode });
                }

                // Redirect to official Cashfree hosted payment page (UPI QR, GPay, PhonePe, Cards, NetBanking)
                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_self"
                });
            } catch (err) {
                console.error("Cashfree Checkout Error:", err);
                const title = document.getElementById('statusTitle');
                const desc = document.getElementById('statusDesc');
                if (title) title.innerText = "Payment Ready";
                if (desc) desc.innerText = "Click the button below to complete your payment on Cashfree.";
            }
        }

        // Trigger automatically on page load
        window.addEventListener('load', function() {
            setTimeout(triggerCashfree, 400);
        });
    </script>
</body>
</html>
