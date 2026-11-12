<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecting to Secure Payment Gateway | SkillLearner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #032a24 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #ffffff;
        }
        .checkout-card {
            background: rgba(255, 255, 255, 0.98);
            color: #0f172a;
            max-width: 480px;
            width: 100%;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        .logo-wrap {
            margin-bottom: 1.5rem;
        }
        .logo-img {
            max-width: 160px;
            height: auto;
        }
        .spinner {
            width: 52px;
            height: 52px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #05B396;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
            margin: 1.5rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .desc {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }
        .order-pill {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .badge-secure {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #059669;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid #a7f3d0;
        }
        .btn-retry {
            display: inline-block;
            margin-top: 1rem;
            padding: 10px 24px;
            background: #05B396;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-retry:hover {
            background: #048873;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="checkout-card">
        <div class="logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" class="logo-img" onerror="this.src='/images/logo.png';">
        </div>

        <div class="spinner" id="paymentSpinner"></div>

        <h1 class="title" id="statusTitle">Connecting to Cashfree...</h1>
        <p class="desc" id="statusDesc">Please wait while we redirect you to the secure payment screen. Do not refresh or press back.</p>

        <div class="order-pill">
            <div style="text-align: left;">
                <div style="font-size: 0.78rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Package</div>
                <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">{{ $order['package_name'] ?? 'Course Package' }}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.78rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Total Payable</div>
                <div style="font-weight: 900; color: #05B396; font-size: 1.25rem;">₹{{ number_format($order['amount'] ?? 0) }}</div>
            </div>
        </div>

        <div class="badge-secure">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>256-Bit SSL Encrypted &amp; RBI Approved PG</span>
        </div>

        <div id="fallbackAction" style="display: none; margin-top: 1.2rem;">
            <p style="font-size: 0.85rem; color: #dc2626; margin-bottom: 0.5rem;">Window did not open automatically?</p>
            <button onclick="triggerCashfreeCheckout()" class="btn-retry">Click to Pay Now</button>
            <br>
            <a href="{{ url('/buy-now') }}" style="display: inline-block; margin-top: 0.8rem; font-size: 0.82rem; color: #64748b; text-decoration: underline;">Return to Checkout</a>
        </div>
    </div>

    <script>
        const paymentSessionId = @json($paymentSessionId);
        const cashfreeMode = @json($environment === 'production' ? 'production' : 'sandbox');

        let cashfree = null;

        function triggerCashfreeCheckout() {
            try {
                if (!cashfree) {
                    cashfree = Cashfree({ mode: cashfreeMode });
                }

                cashfree.checkout({
                    paymentSessionId: paymentSessionId,
                    redirectTarget: "_self"
                });
            } catch (err) {
                console.error("Cashfree Checkout Error:", err);
                document.getElementById('statusTitle').innerText = "Action Required";
                document.getElementById('statusDesc').innerText = "Please click below to complete your payment securely on Cashfree.";
                document.getElementById('fallbackAction').style.display = 'block';
            }
        }

        // Auto trigger upon page load
        window.addEventListener('load', function() {
            setTimeout(triggerCashfreeCheckout, 600);

            // Show manual button after 4 seconds if browser blocked auto redirect
            setTimeout(function() {
                document.getElementById('fallbackAction').style.display = 'block';
            }, 4000);
        });
    </script>
</body>
</html>
