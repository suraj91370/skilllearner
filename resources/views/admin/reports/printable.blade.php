<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillLearner Analytics &amp; Performance Report — {{ $rangeLabel }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 2rem;
            line-height: 1.5;
        }
        .report-sheet {
            max-width: 1000px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #05B396;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        .logo-img { max-height: 50px; }
        .meta-pill {
            display: inline-block;
            background: #f0fdf9;
            color: #05B396;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            border: 1px solid #a7f3d0;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.2rem;
            margin-bottom: 2.5rem;
        }
        .kpi-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.2rem;
            text-align: center;
        }
        .kpi-title { font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .kpi-value { font-size: 1.6rem; font-weight: 900; color: #0f172a; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5rem;
            font-size: 0.88rem;
        }
        th {
            background: #0f172a;
            color: #ffffff;
            font-weight: 800;
            padding: 10px 14px;
            text-align: left;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
        }
        tr:nth-child(even) td { background: #fafafa; }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 800;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .footer-signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #64748b;
        }
        .signature-line {
            width: 200px;
            border-top: 1.5px solid #94a3b8;
            margin-top: 2.5rem;
            padding-top: 4px;
            text-align: center;
            font-weight: 700;
            color: #0f172a;
        }
        .action-bar {
            max-width: 1000px;
            margin: 0 auto 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #05B396;
            color: #fff;
            font-weight: 800;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(5, 179, 150, 0.25);
        }
        .btn-back {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        @media print {
            body { background: #ffffff; padding: 0; }
            .report-sheet { box-shadow: none; border: none; padding: 0; max-width: 100%; }
            .action-bar { display: none !important; }
            @page { margin: 1.5cm; size: A4 portrait; }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <a href="{{ route('admin.reports.index') }}" class="btn-back">← Back to Dashboard</a>
        <button type="button" onclick="window.print()" class="btn-print">🖨️ Print / Save as PDF</button>
    </div>

    <div class="report-sheet">
        <!-- Letterhead Header -->
        <div class="header">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" class="logo-img" onerror="this.src='/images/logo.png'">
                <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">SkillLearner Edutech Private Limited — ISO 9001:2015 Accredited</div>
            </div>
            <div style="text-align: right;">
                <span class="meta-pill">OFFICIAL EXECUTIVE REPORT</span>
                <h3 style="margin: 6px 0 2px; color: #0f172a; font-size: 1.25rem;">Analytics &amp; Performance Summary</h3>
                <div style="font-size: 0.82rem; color: #64748b;">Period: <strong>{{ $rangeLabel }}</strong> | Date: <strong>{{ now()->format('d M, Y H:i') }}</strong></div>
            </div>
        </div>

        <!-- KPI Grid Summary -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-title">Gross Revenue</div>
                <div class="kpi-value" style="color: #05B396;">₹{{ number_format($grossRevenue, 2) }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Net Revenue</div>
                <div class="kpi-value" style="color: #0B4F4A;">₹{{ number_format($netRevenue, 2) }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Paid Orders</div>
                <div class="kpi-value">{{ $paidCount }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Platform Completion</div>
                <div class="kpi-value" style="color: #7c3aed;">{{ $completionRate }}%</div>
            </div>
        </div>

        <!-- Section: Recent Orders & Transactions -->
        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.8rem;">
            <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">Orders &amp; Payment Transactions</h4>
            <span style="font-size: 0.8rem; color: #64748b;">Showing {{ count($orders) }} records</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Buyer Name</th>
                    <th>Package</th>
                    <th class="text-right">Amount</th>
                    <th>Status</th>
                    <th>Invoice No</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td style="font-family: monospace; font-weight: 700;">{{ $o->order_id }}</td>
                        <td>{{ $o->created_at ? $o->created_at->format('d M, Y') : '' }}</td>
                        <td>
                            <strong>{{ $o->buyer_name }}</strong>
                            <div style="font-size: 0.76rem; color: #64748b;">{{ $o->buyer_email }}</div>
                        </td>
                        <td>{{ $o->package_name }}</td>
                        <td class="text-right" style="font-weight: 700;">₹{{ number_format((float)$o->amount, 2) }}</td>
                        <td>
                            @if($o->payment_status === 'paid')
                                <span class="badge badge-success">PAID</span>
                            @elseif($o->payment_status === 'refunded')
                                <span class="badge badge-danger">REFUNDED</span>
                            @else
                                <span class="badge badge-warning">{{ strtoupper($o->payment_status) }}</span>
                            @endif
                        </td>
                        <td style="font-family: monospace; font-size: 0.8rem;">{{ $o->invoice_number ?: 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748b; padding: 2rem;">No order records found in this date range.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Section: Top Selling Courses -->
        <div style="margin-bottom: 0.8rem;">
            <h4 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">Top Performing Courses &amp; Completion</h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Course Title</th>
                    <th>Category</th>
                    <th class="text-right">Enrolled Students</th>
                    <th class="text-right">Average Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCourses as $tc)
                    <tr>
                        <td><strong>{{ $tc->title }}</strong></td>
                        <td>{{ $tc->category ?: 'General' }}</td>
                        <td class="text-right" style="font-weight: 700;">{{ $tc->enrolled }} Students</td>
                        <td class="text-right" style="color: #05B396; font-weight: 800;">{{ round((float)$tc->progress, 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer Signatures & Official Stamp -->
        <div class="footer-signatures">
            <div>
                <div>SkillLearner Edutech Private Limited</div>
                <div style="font-size: 0.78rem; color: #94a3b8;">System-generated audit statement. Valid without physical stamp.</div>
            </div>
            <div>
                <div class="signature-line">
                    {{ \App\Models\Setting::get('cert_signatory_name', 'Adarsh Pandey') }}
                    <div style="font-size: 0.76rem; font-weight: normal; color: #64748b;">Chief Executive Officer</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

