<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body { font-family: Calibri, Arial, sans-serif; }
        .header-title { font-size: 16pt; font-weight: bold; color: #05B396; }
        .meta-text { font-size: 10pt; color: #555555; }
        th { background-color: #05B396; color: #ffffff; font-weight: bold; padding: 8px 12px; border: 1px solid #048c75; text-align: left; }
        td { padding: 6px 12px; border: 1px solid #dddddd; }
        .num { text-align: right; }
        .total-row { font-weight: bold; background-color: #f0fdf9; border-top: 2px solid #05B396; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="6" class="header-title">SkillLearner Official Analytics &amp; Performance Report</td>
        </tr>
        <tr>
            <td colspan="6" class="meta-text">Report Type: {{ strtoupper($type) }} | Filter Period: {{ $rangeLabel }} ({{ $start->format('d M, Y') }} to {{ $end->format('d M, Y') }})</td>
        </tr>
        <tr>
            <td colspan="6" class="meta-text">Generated At: {{ now()->format('d M, Y H:i:s') }} | Platform: SkillLearner Edutech</td>
        </tr>
        <tr><td colspan="6"></td></tr>

        @if($type === 'courses')
            <tr>
                <th>Course Title</th>
                <th>Category</th>
                <th class="num">Price (INR)</th>
                <th class="num">Enrolled Students</th>
                <th class="num">Completed Count</th>
                <th class="num">Avg Progress</th>
            </tr>
            @foreach($courses as $c)
                <tr>
                    <td>{{ $c->title }}</td>
                    <td>{{ $c->category ?: 'General' }}</td>
                    <td class="num">₹{{ number_format((float)$c->price, 2) }}</td>
                    <td class="num">{{ $c->total_enrolled }}</td>
                    <td class="num">{{ $c->completed_count }}</td>
                    <td class="num">{{ round((float)$c->avg_progress, 1) }}%</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total Active Courses: {{ count($courses) }}</td>
                <td class="num">{{ $courses->sum('total_enrolled') }}</td>
                <td class="num">{{ $courses->sum('completed_count') }}</td>
                <td></td>
            </tr>

        @elseif($type === 'mentors')
            <tr>
                <th>Mentor Name</th>
                <th>Email</th>
                <th>Expertise</th>
                <th class="num">Commission %</th>
                <th>Assigned Courses</th>
                <th class="num">Total Earned (INR)</th>
                <th class="num">Wallet Balance (INR)</th>
                <th>Status</th>
            </tr>
            @foreach($mentors as $m)
                <tr>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->expertise }}</td>
                    <td class="num">{{ $m->commission_percentage }}%</td>
                    <td>{{ is_array($m->assigned_courses) ? implode(', ', $m->assigned_courses) : '' }}</td>
                    <td class="num">₹{{ number_format((float)$m->total_earned, 2) }}</td>
                    <td class="num">₹{{ number_format((float)$m->wallet_balance, 2) }}</td>
                    <td>{{ ucfirst($m->status) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">Total Mentors: {{ count($mentors) }}</td>
                <td class="num">₹{{ number_format((float)$mentors->sum('total_earned'), 2) }}</td>
                <td class="num">₹{{ number_format((float)$mentors->sum('wallet_balance'), 2) }}</td>
                <td></td>
            </tr>

        @elseif($type === 'users')
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registration Date</th>
                <th class="num">Enrolled Courses</th>
            </tr>
            @foreach($users as $u)
                <tr>
                    <td>#{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $u->role)) }}</td>
                    <td>{{ $u->is_blocked ? 'Blocked' : 'Active' }}</td>
                    <td>{{ $u->created_at ? $u->created_at->format('d M, Y H:i') : '' }}</td>
                    <td class="num">{{ $u->user_courses_count }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6">Total Students / Users: {{ count($users) }}</td>
                <td class="num">{{ $users->sum('user_courses_count') }}</td>
            </tr>

        @else
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Buyer Name</th>
                <th>Buyer Email</th>
                <th>Package Purchased</th>
                <th class="num">Amount (INR)</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Transaction ID</th>
                <th>Invoice Number</th>
            </tr>
            @php $paidSum = 0; @endphp
            @foreach($orders as $o)
                @if($o->payment_status === 'paid') @php $paidSum += (float)$o->amount; @endphp @endif
                <tr>
                    <td>{{ $o->order_id }}</td>
                    <td>{{ $o->created_at ? $o->created_at->format('d M, Y H:i') : '' }}</td>
                    <td>{{ $o->buyer_name }}</td>
                    <td>{{ $o->buyer_email }}</td>
                    <td>{{ $o->package_name }}</td>
                    <td class="num">₹{{ number_format((float)$o->amount, 2) }}</td>
                    <td>{{ strtoupper($o->payment_status) }}</td>
                    <td>{{ strtoupper($o->payment_method ?: 'Cashfree') }}</td>
                    <td>{{ $o->transaction_id ?: 'N/A' }}</td>
                    <td>{{ $o->invoice_number ?: 'N/A' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">Total Orders: {{ count($orders) }}</td>
                <td class="num">₹{{ number_format($paidSum, 2) }}</td>
                <td colspan="4">Net Paid Volume</td>
            </tr>
        @endif
    </table>
</body>
</html>
