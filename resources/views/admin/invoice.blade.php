<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice {{ $order->invoice_number }} — SkillLearner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 2.5rem 1rem;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .invoice-wrapper {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            padding: 2.5rem 3rem;
            position: relative;
            overflow: hidden;
        }
        .invoice-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1.5px solid #f1f5f9;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-logo img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }
        .brand-name {
            font-size: 1.6rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .brand-name span {
            color: #05B396;
        }
        .invoice-title-block {
            text-align: right;
        }
        .invoice-heading {
            font-size: 1.5rem;
            font-weight: 900;
            color: #05B396;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .invoice-num {
            font-size: 0.95rem;
            font-weight: 800;
            color: #334155;
            font-family: monospace;
            margin-top: 2px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
            font-size: 0.88rem;
        }
        .meta-col h4 {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #64748b;
            font-weight: 800;
            margin-bottom: 0.6rem;
        }
        .meta-col p {
            line-height: 1.6;
            color: #334155;
        }
        .meta-col strong {
            color: #0f172a;
        }
        .table-wrapper {
            margin-bottom: 2rem;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
            text-align: left;
        }
        thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }
        th {
            padding: 0.85rem 1rem;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            font-weight: 800;
        }
        td {
            padding: 1rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }
        .calc-grid {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2.5rem;
        }
        .calc-box {
            width: 320px;
            font-size: 0.88rem;
        }
        .calc-row {
            display: flex;
            justify-content: space-between;
            padding: 0.45rem 0;
            color: #475569;
        }
        .calc-row.total {
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            padding: 0.75rem 0;
            margin-top: 0.4rem;
            font-size: 1.15rem;
            font-weight: 900;
            color: #0f172a;
        }
        .paid-stamp {
            position: absolute;
            top: 220px;
            right: 80px;
            border: 3.5px dashed #05B396;
            color: #05B396;
            font-size: 1.6rem;
            font-weight: 900;
            text-transform: uppercase;
            padding: 0.4rem 1.4rem;
            border-radius: 8px;
            transform: rotate(-12deg);
            opacity: 0.82;
            letter-spacing: 2px;
            pointer-events: none;
        }
        .invoice-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 1.4rem;
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.6;
            text-align: center;
        }
        .action-bar {
            max-width: 820px;
            margin: 0 auto 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.65rem 1.3rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-print {
            background: #05B396;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);
        }
        .btn-back {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .action-bar {
                display: none !important;
            }
            .invoice-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .paid-stamp {
                right: 60px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (Hidden in Print) -->
    <div class="action-bar">
        <a href="javascript:history.back()" class="btn-action btn-back">
            ← Back
        </a>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-action btn-print">
                🖨️ Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Printable Invoice Container -->
    <div class="invoice-wrapper">
        
        <!-- Paid Watermark Stamp -->
        <div class="paid-stamp">
            ✔ {{ strtoupper($order->payment_status) }}
        </div>

        <!-- Top Header & Brand -->
        <div class="invoice-top-bar">
            <div class="brand-logo">
                <img src="{{ asset('assets/logo.png') }}" onerror="this.style.display='none'" alt="SkillLearner">
                <div class="brand-name">Skill<span>Learner</span></div>
            </div>
            <div class="invoice-title-block">
                <div class="invoice-heading">Tax Invoice</div>
                <div class="invoice-num">{{ $order->invoice_number }}</div>
            </div>
        </div>

        <!-- Metadata Grid (Seller & Buyer) -->
        <div class="meta-grid">
            <div class="meta-col">
                <h4>Sold By / Service Provider</h4>
                <p><strong>SkillLearner Edutech Private Limited</strong></p>
                <p>Digital Skill Learning &amp; Affiliate Platform</p>
                <p>New Delhi, Delhi - 110001, India</p>
                <p><strong>GSTIN:</strong> 07AABCS1429B1Z2</p>
                <p><strong>Support Email:</strong> support@skilllearne.org</p>
            </div>
            <div class="meta-col" style="text-align: right;">
                <h4>Billed To / Customer Details</h4>
                <p><strong>{{ $order->buyer_name }}</strong></p>
                <p>{{ $order->buyer_email }}</p>
                <p>Phone: {{ $order->buyer_phone ?: 'N/A' }}</p>
                <p>Place of Supply: India (Inter-State/Intra-State)</p>
                <div style="margin-top: 0.6rem; padding-top: 0.4rem; border-top: 1px dashed #e2e8f0;">
                    <p><strong>Invoice Date:</strong> {{ $order->created_at ? $order->created_at->format('d M, Y') : date('d M, Y') }}</p>
                    <p><strong>Order ID:</strong> #{{ $order->order_id }}</p>
                    <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method ?? 'ONLINE') }}</p>
                    <p><strong>Transaction UTR:</strong> {{ $order->transaction_id ?: 'CONFIRMED' }}</p>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Description of Services</th>
                        <th style="width: 90px; text-align: center;">SAC Code</th>
                        <th style="width: 50px; text-align: center;">Qty</th>
                        <th style="width: 110px; text-align: right;">Taxable Value</th>
                        <th style="width: 110px; text-align: right;">GST (18%)</th>
                        <th style="width: 120px; text-align: right;">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 700; color: #64748b;">1</td>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">
                                {{ $order->package_name }}
                            </div>
                            <div style="font-size: 0.78rem; color: #64748b; margin-top: 2px;">
                                Online Digital Skill Mastery Course Bundle &amp; Masterclass Classroom Access
                            </div>
                        </td>
                        <td style="text-align: center; font-family: monospace; font-weight: 700; color: #475569;">
                            999293
                        </td>
                        <td style="text-align: center; font-weight: 700;">
                            1
                        </td>
                        <td style="text-align: right; font-weight: 700;">
                            ₹{{ number_format($taxableValue, 2) }}
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #475569;">
                            ₹{{ number_format($totalGst, 2) }}
                        </td>
                        <td style="text-align: right; font-weight: 800; color: #05B396; font-size: 0.95rem;">
                            ₹{{ number_format($totalPaid, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tax Breakdown & Calculation Summary -->
        <div class="calc-grid">
            <div class="calc-box">
                <div class="calc-row">
                    <span>Taxable Value:</span>
                    <strong>₹{{ number_format($taxableValue, 2) }}</strong>
                </div>
                <div class="calc-row">
                    <span>CGST (9.0%):</span>
                    <strong>₹{{ number_format($cgst, 2) }}</strong>
                </div>
                <div class="calc-row">
                    <span>SGST (9.0%):</span>
                    <strong>₹{{ number_format($sgst, 2) }}</strong>
                </div>
                <div class="calc-row total">
                    <span>Total Amount Paid:</span>
                    <span>₹{{ number_format($totalPaid, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Amount In Words & Terms -->
        <div style="background: #f8fafc; border-left: 3px solid #05B396; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.82rem; color: #334155;">
            <strong>Amount Paid:</strong> Indian Rupees {{ number_format($totalPaid, 2) }} (All taxes included).
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p>This is a computer-generated electronic tax invoice and does not require a physical signature.</p>
            <p>SkillLearner Edutech Private Limited • Thank you for learning with us!</p>
        </div>

    </div>

</body>
</html>

