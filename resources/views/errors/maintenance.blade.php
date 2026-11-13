<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance in Progress — {{ $siteName ?? 'SkillLearner' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #080314;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient glowing background blobs */
        .glow-blob-1 {
            position: absolute;
            top: -10%;
            left: 20%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.28) 0%, rgba(124, 58, 237, 0) 70%);
            border-radius: 50%;
            filter: blur(50px);
            z-index: 1;
            pointer-events: none;
        }

        .glow-blob-2 {
            position: absolute;
            bottom: -10%;
            right: 20%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(5, 179, 150, 0.22) 0%, rgba(5, 179, 150, 0) 70%);
            border-radius: 50%;
            filter: blur(50px);
            z-index: 1;
            pointer-events: none;
        }

        .maintenance-card {
            position: relative;
            z-index: 2;
            max-width: 680px;
            width: 100%;
            background: rgba(18, 11, 35, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            padding: 3.5rem 3rem;
            text-align: center;
            box-shadow: 0 30px 80px -20px rgba(0, 0, 0, 0.8), 0 0 40px rgba(124, 58, 237, 0.15);
        }

        .gear-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 86px;
            height: 86px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.2) 0%, rgba(5, 179, 150, 0.18) 100%);
            border: 1.5px solid rgba(124, 58, 237, 0.4);
            margin-bottom: 2rem;
            box-shadow: 0 12px 30px rgba(124, 58, 237, 0.3);
            animation: pulse-glow 3s infinite alternate;
        }

        @keyframes pulse-glow {
            0% { transform: scale(1); box-shadow: 0 12px 30px rgba(124, 58, 237, 0.25); }
            100% { transform: scale(1.05); box-shadow: 0 18px 45px rgba(5, 179, 150, 0.4); }
        }

        .gear-icon {
            font-size: 2.8rem;
            display: inline-block;
            animation: spin-gear 12s linear infinite;
        }

        @keyframes spin-gear {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.4);
            color: #f59e0b;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f59e0b;
            display: inline-block;
            box-shadow: 0 0 10px #f59e0b;
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.9); opacity: 0.7; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.7; }
        }

        h1 {
            font-size: 2.1rem;
            font-weight: 900;
            line-height: 1.25;
            margin-bottom: 1.2rem;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.desc {
            font-size: 1.05rem;
            color: #94a3b8;
            line-height: 1.7;
            margin-bottom: 2.2rem;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 1.2rem 1.6rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2.2rem;
            text-align: left;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .info-val {
            font-size: 0.98rem;
            font-weight: 800;
            color: #f1f5f9;
        }

        .btn-row {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-contact {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #05B396 0%, #048873 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 0.85rem 1.8rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            box-shadow: 0 6px 20px rgba(5, 179, 150, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(5, 179, 150, 0.5);
        }

        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.85rem 1.6rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .btn-admin:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .footer-note {
            margin-top: 2.2rem;
            font-size: 0.82rem;
            color: #64748b;
        }

        @media (max-width: 640px) {
            .maintenance-card {
                padding: 2.5rem 1.5rem;
            }
            h1 {
                font-size: 1.65rem;
            }
            .info-box {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="glow-blob-1"></div>
    <div class="glow-blob-2"></div>

    <div class="maintenance-card">
        <div class="gear-wrapper">
            <span class="gear-icon">⚙️</span>
        </div>

        <div>
            <div class="status-pill">
                <span class="pulse-dot"></span>
                <span>System Upgrade in Progress</span>
            </div>
        </div>

        <h1>{{ $title ?? 'Scheduled Platform Maintenance' }}</h1>

        <p class="desc">
            {{ $message ?? 'We are upgrading our platform infrastructure to deliver a faster and smoother learning experience. We will be back online shortly!' }}
        </p>

        <div class="info-box">
            <div>
                <div class="info-label">Platform</div>
                <div class="info-val">{{ $siteName ?? 'SkillLearner' }}</div>
            </div>
            <div>
                <div class="info-label">Expected Uptime</div>
                <div class="info-val" style="color: #05B396;">{{ $endTime ?? 'Shortly' }}</div>
            </div>
            <div>
                <div class="info-label">Emergency Help</div>
                <div class="info-val">{{ $contactEmail ?? 'support@skilllearner.org' }}</div>
            </div>
        </div>

        <div class="btn-row">
            @if(!empty($contactWhatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}" target="_blank" class="btn-contact">
                    <span>💬 WhatsApp Support</span>
                </a>
            @else
                <a href="mailto:{{ $contactEmail ?? 'support@skilllearner.org' }}" class="btn-contact">
                    <span>✉️ Email Support</span>
                </a>
            @endif

            <a href="{{ url('/login') }}" class="btn-admin">
                <span>🔐 Admin / Staff Login</span>
            </a>
        </div>

        <div class="footer-note">
            &copy; {{ date('Y') }} {{ $siteName ?? 'SkillLearner' }}. All rights reserved.
        </div>
    </div>
</body>
</html>

