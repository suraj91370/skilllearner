<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mentor;
use App\Models\MentorPayout;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Resolve date range filter from query parameters.
     *
     * @return array{0: Carbon, 1: Carbon, 2: string, 3: string}
     */
    protected function getDateRange(Request $request): array
    {
        $range = $request->query('range', '30days');
        $now = Carbon::now();

        switch ($range) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                $label = 'Today ('.$start->format('d M, Y').')';
                break;
            case 'yesterday':
                $start = $now->copy()->subDay()->startOfDay();
                $end = $now->copy()->subDay()->endOfDay();
                $label = 'Yesterday ('.$start->format('d M, Y').')';
                break;
            case '7days':
                $start = $now->copy()->subDays(6)->startOfDay();
                $end = $now->copy()->endOfDay();
                $label = 'Last 7 Days';
                break;
            case 'this_month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfDay();
                $label = 'This Month ('.$start->format('F Y').')';
                break;
            case 'last_month':
                $start = $now->copy()->subMonth()->startOfMonth();
                $end = $now->copy()->subMonth()->endOfMonth();
                $label = 'Last Month ('.$start->format('F Y').')';
                break;
            case 'this_year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfDay();
                $label = 'This Year ('.$start->format('Y').')';
                break;
            case 'all_time':
                $start = Carbon::parse('2020-01-01 00:00:00');
                $end = $now->copy()->endOfDay();
                $label = 'All Time';
                break;
            case 'custom':
                $start = $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : $now->copy()->subDays(29)->startOfDay();
                $end = $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : $now->copy()->endOfDay();
                $label = $start->format('d M Y').' — '.$end->format('d M Y');
                break;
            case '30days':
            default:
                $range = '30days';
                $start = $now->copy()->subDays(29)->startOfDay();
                $end = $now->copy()->endOfDay();
                $label = 'Last 30 Days';
                break;
        }

        return [$start, $end, $range, $label];
    }

    /**
     * Executive Overview & Analytics Dashboard.
     */
    public function index(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);

        // Core Revenue KPIs in selected range
        $grossRevenue = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $refundedAmount = (float) Order::where(function ($q) {
            $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
        })->whereBetween('created_at', [$start, $end])->sum('refund_amount');

        $netRevenue = max(0, $grossRevenue - $refundedAmount);

        $totalOrdersCount = Order::whereBetween('created_at', [$start, $end])->count();
        $paidOrdersCount = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->count();
        $pendingOrdersCount = Order::where('payment_status', 'pending')->whereBetween('created_at', [$start, $end])->count();
        $refundedOrdersCount = Order::where(function ($q) {
            $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
        })->whereBetween('created_at', [$start, $end])->count();

        $avgOrderValue = $paidOrdersCount > 0 ? ($grossRevenue / $paidOrdersCount) : 0;

        // Daily Trend (Last 14 to 30 days)
        $dailyTrend = [];
        $cursor = $start->copy()->startOfDay();
        $limitDays = min(31, $cursor->diffInDays($end) + 1);

        for ($i = 0; $i < $limitDays; $i++) {
            $dayStart = $cursor->copy()->startOfDay();
            $dayEnd = $cursor->copy()->endOfDay();
            $dayKey = $dayStart->format('Y-m-d');
            $dayLabel = $dayStart->format('d M');

            $dayRevenue = (float) Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->sum('amount');

            $dayOrders = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->count();

            $dailyTrend[] = [
                'date' => $dayKey,
                'label' => $dayLabel,
                'revenue' => $dayRevenue,
                'orders' => $dayOrders,
            ];

            $cursor->addDay();
        }

        // Package Sales Breakdown in range
        $packageBreakdown = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select('package_name', DB::raw('count(*) as count'), DB::raw('sum(amount) as revenue'))
            ->groupBy('package_name')
            ->orderByDesc('revenue')
            ->get();

        // Top Selling Courses by Enrolled Students
        $topCourses = Course::leftJoin('user_courses', 'courses.id', '=', 'user_courses.course_id')
            ->select(
                'courses.id',
                'courses.title',
                'courses.category',
                'courses.price',
                DB::raw('COUNT(user_courses.id) as total_enrolled'),
                DB::raw('COUNT(CASE WHEN user_courses.progress_percent = 100 THEN 1 END) as completed_count'),
                DB::raw('COALESCE(AVG(user_courses.progress_percent), 0) as avg_progress')
            )
            ->groupBy('courses.id', 'courses.title', 'courses.category', 'courses.price')
            ->orderByDesc('total_enrolled')
            ->limit(5)
            ->get();

        // Mentors Quick Overview
        $topMentors = Mentor::orderByDesc('total_earned')->limit(4)->get();

        // User Growth Snapshot
        $totalUsers = User::count();
        $newUsersInRange = User::whereBetween('created_at', [$start, $end])->count();
        $activeUsers = User::where('is_blocked', false)->count();

        // Platform Completion Rate
        $totalEnrollments = UserCourse::count();
        $completedEnrollments = UserCourse::where('progress_percent', 100)->count();
        $overallCompletionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0;
        $avgPlatformProgress = round(UserCourse::avg('progress_percent') ?? 0, 1);

        return view('admin.reports.index', compact(
            'start',
            'end',
            'range',
            'rangeLabel',
            'grossRevenue',
            'refundedAmount',
            'netRevenue',
            'totalOrdersCount',
            'paidOrdersCount',
            'pendingOrdersCount',
            'refundedOrdersCount',
            'avgOrderValue',
            'dailyTrend',
            'packageBreakdown',
            'topCourses',
            'topMentors',
            'totalUsers',
            'newUsersInRange',
            'activeUsers',
            'overallCompletionRate',
            'avgPlatformProgress'
        ));
    }

    /**
     * Sales & Revenue Detailed Report.
     */
    public function revenue(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);

        $grossRevenue = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $refundedAmount = (float) Order::where(function ($q) {
            $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
        })->whereBetween('created_at', [$start, $end])->sum('refund_amount');

        $netRevenue = max(0, $grossRevenue - $refundedAmount);
        $paidCount = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->count();
        $avgOrderValue = $paidCount > 0 ? ($grossRevenue / $paidCount) : 0;

        // Daily Breakdown Table
        $dailyRecords = [];
        $cursor = $end->copy()->startOfDay();
        $daysCount = min(60, $cursor->diffInDays($start) + 1);

        for ($i = 0; $i < $daysCount; $i++) {
            $dayStart = $cursor->copy()->startOfDay();
            $dayEnd = $cursor->copy()->endOfDay();

            $ordersCount = Order::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $dayPaid = Order::where('payment_status', 'paid')->whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $dayGross = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$dayStart, $dayEnd])->sum('amount');
            $dayRefund = (float) Order::where(function ($q) {
                $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
            })->whereBetween('created_at', [$dayStart, $dayEnd])->sum('refund_amount');

            if ($ordersCount > 0 || $i < 14) {
                $dailyRecords[] = [
                    'date' => $cursor->format('d M, Y'),
                    'day_name' => $cursor->format('l'),
                    'total_orders' => $ordersCount,
                    'paid_orders' => $dayPaid,
                    'gross_amount' => $dayGross,
                    'refund_amount' => $dayRefund,
                    'net_amount' => max(0, $dayGross - $dayRefund),
                ];
            }

            $cursor->subDay();
        }

        // Monthly Breakdown (Last 6 Months)
        $monthlyRecords = [];
        $monthCursor = Carbon::now()->startOfMonth();

        for ($m = 0; $m < 6; $m++) {
            $mStart = $monthCursor->copy()->startOfMonth();
            $mEnd = $monthCursor->copy()->endOfMonth();

            $mOrders = Order::where('payment_status', 'paid')->whereBetween('created_at', [$mStart, $mEnd])->count();
            $mGross = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$mStart, $mEnd])->sum('amount');
            $mRefund = (float) Order::where(function ($q) {
                $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
            })->whereBetween('created_at', [$mStart, $mEnd])->sum('refund_amount');

            $monthlyRecords[] = [
                'month_name' => $monthCursor->format('F Y'),
                'paid_orders' => $mOrders,
                'gross_amount' => $mGross,
                'net_amount' => max(0, $mGross - $mRefund),
                'is_current' => ($m === 0),
            ];

            $monthCursor->subMonth();
        }

        // Payment Method Distribution
        $paymentMethods = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        return view('admin.reports.revenue', compact(
            'start',
            'end',
            'range',
            'rangeLabel',
            'grossRevenue',
            'refundedAmount',
            'netRevenue',
            'paidCount',
            'avgOrderValue',
            'dailyRecords',
            'monthlyRecords',
            'paymentMethods'
        ));
    }

    /**
     * Top Selling Courses & Packages Report.
     */
    public function courses(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);

        // Package Performance
        $packages = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                'package_name',
                DB::raw('count(*) as units_sold'),
                DB::raw('sum(amount) as total_revenue'),
                DB::raw('avg(amount) as avg_price')
            )
            ->groupBy('package_name')
            ->orderByDesc('total_revenue')
            ->get();

        $totalPackageRevenue = $packages->sum('total_revenue');

        // Course Performance with Completion Metrics
        $courses = Course::leftJoin('user_courses', 'courses.id', '=', 'user_courses.course_id')
            ->select(
                'courses.id',
                'courses.title',
                'courses.slug',
                'courses.category',
                'courses.price',
                DB::raw('COUNT(user_courses.id) as total_enrolled'),
                DB::raw('COUNT(CASE WHEN user_courses.progress_percent = 100 THEN 1 END) as completed_count'),
                DB::raw('COUNT(CASE WHEN user_courses.progress_percent > 0 AND user_courses.progress_percent < 100 THEN 1 END) as in_progress_count'),
                DB::raw('COALESCE(AVG(user_courses.progress_percent), 0) as avg_progress')
            )
            ->groupBy('courses.id', 'courses.title', 'courses.slug', 'courses.category', 'courses.price')
            ->orderByDesc('total_enrolled')
            ->get();

        return view('admin.reports.courses', compact(
            'start',
            'end',
            'range',
            'rangeLabel',
            'packages',
            'totalPackageRevenue',
            'courses'
        ));
    }

    /**
     * Mentor-wise Earning & Performance Report.
     */
    public function mentors(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);

        $mentors = Mentor::withCount('payouts')->get()->map(function ($mentor) {
            $processedPayouts = (float) MentorPayout::where('mentor_id', $mentor->id)
                ->where('status', 'processed')
                ->sum('amount');

            $assignedCourses = is_array($mentor->assigned_courses) ? $mentor->assigned_courses : [];

            return [
                'id' => $mentor->id,
                'name' => $mentor->name,
                'email' => $mentor->email,
                'expertise' => $mentor->expertise,
                'designation' => $mentor->designation ?: 'SkillLearner Mentor',
                'commission_percentage' => (float) $mentor->commission_percentage,
                'assigned_courses' => $assignedCourses,
                'total_earned' => (float) $mentor->total_earned,
                'processed_payouts' => $processedPayouts,
                'wallet_balance' => (float) $mentor->wallet_balance,
                'status' => $mentor->status,
                'payouts_count' => $mentor->payouts_count,
            ];
        });

        $totalMentorEarnings = $mentors->sum('total_earned');
        $totalProcessedPayouts = $mentors->sum('processed_payouts');
        $totalPendingWallets = $mentors->sum('wallet_balance');

        return view('admin.reports.mentors', compact(
            'start',
            'end',
            'range',
            'rangeLabel',
            'mentors',
            'totalMentorEarnings',
            'totalProcessedPayouts',
            'totalPendingWallets'
        ));
    }

    /**
     * Users Growth & Course Completion Rate Report.
     */
    public function users(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);

        $totalUsers = User::count();
        $newUsersInRange = User::whereBetween('created_at', [$start, $end])->count();
        $activeUsers = User::where('is_blocked', false)->count();
        $blockedUsers = User::where('is_blocked', true)->count();

        // User Growth by Month (Last 6 Months)
        $userGrowthMonthly = [];
        $mCursor = Carbon::now()->startOfMonth();

        for ($i = 0; $i < 6; $i++) {
            $mStart = $mCursor->copy()->startOfMonth();
            $mEnd = $mCursor->copy()->endOfMonth();

            $count = User::whereBetween('created_at', [$mStart, $mEnd])->count();

            $userGrowthMonthly[] = [
                'month' => $mCursor->format('F Y'),
                'count' => $count,
            ];

            $mCursor->subMonth();
        }

        // Completion Rate Metrics
        $totalEnrollments = UserCourse::count();
        $completedCount = UserCourse::where('progress_percent', 100)->count();
        $inProgressCount = UserCourse::where('progress_percent', '<', 100)->where('progress_percent', '>', 0)->count();
        $notStartedCount = UserCourse::where('progress_percent', 0)->count();

        $overallCompletionRate = $totalEnrollments > 0 ? round(($completedCount / $totalEnrollments) * 100, 1) : 0;
        $avgProgress = round(UserCourse::avg('progress_percent') ?? 0, 1);

        // Student List with Course Progress Breakdown
        $students = User::withCount('userCourses')
            ->with(['userCourses.course'])
            ->orderByDesc('created_at')
            ->limit(25)
            ->get();

        return view('admin.reports.users', compact(
            'start',
            'end',
            'range',
            'rangeLabel',
            'totalUsers',
            'newUsersInRange',
            'activeUsers',
            'blockedUsers',
            'userGrowthMonthly',
            'totalEnrollments',
            'completedCount',
            'inProgressCount',
            'notStartedCount',
            'overallCompletionRate',
            'avgProgress',
            'students'
        ));
    }

    /**
     * Export Report to CSV.
     */
    public function exportCsv(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);
        $type = $request->query('type', 'revenue');
        $fileName = 'skilllearner_'.$type.'_report_'.date('Y-m-d').'.csv';

        $response = new StreamedResponse(function () use ($type, $start, $end) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM so Excel opens with proper encoding
            fwrite($handle, "\xEF\xBB\xBF");

            if ($type === 'courses') {
                fputcsv($handle, ['Course Title', 'Category', 'Price (INR)', 'Total Students Enrolled', 'Completed Count', 'Completion Rate (%)', 'Average Progress (%)']);

                $courses = Course::leftJoin('user_courses', 'courses.id', '=', 'user_courses.course_id')
                    ->select(
                        'courses.title',
                        'courses.category',
                        'courses.price',
                        DB::raw('COUNT(user_courses.id) as total_enrolled'),
                        DB::raw('COUNT(CASE WHEN user_courses.progress_percent = 100 THEN 1 END) as completed_count'),
                        DB::raw('COALESCE(AVG(user_courses.progress_percent), 0) as avg_progress')
                    )
                    ->groupBy('courses.id', 'courses.title', 'courses.category', 'courses.price')
                    ->orderByDesc('total_enrolled')
                    ->get();

                foreach ($courses as $c) {
                    $compRate = $c->total_enrolled > 0 ? round(($c->completed_count / $c->total_enrolled) * 100, 1) : 0;
                    fputcsv($handle, [
                        $c->title,
                        $c->category ?: 'General',
                        number_format((float) $c->price, 2),
                        $c->total_enrolled,
                        $c->completed_count,
                        $compRate.'%',
                        round((float) $c->avg_progress, 1).'%',
                    ]);
                }
            } elseif ($type === 'mentors') {
                fputcsv($handle, ['Mentor Name', 'Email', 'Expertise', 'Commission %', 'Assigned Courses', 'Total Earned (INR)', 'Wallet Balance (INR)', 'Status']);

                $mentors = Mentor::all();
                foreach ($mentors as $m) {
                    $coursesStr = is_array($m->assigned_courses) ? implode(', ', $m->assigned_courses) : '';
                    fputcsv($handle, [
                        $m->name,
                        $m->email,
                        $m->expertise ?: 'Mentorship',
                        $m->commission_percentage.'%',
                        $coursesStr,
                        number_format((float) $m->total_earned, 2),
                        number_format((float) $m->wallet_balance, 2),
                        ucfirst($m->status),
                    ]);
                }
            } elseif ($type === 'users') {
                fputcsv($handle, ['User ID', 'Name', 'Email', 'Role', 'Status', 'Registered Date', 'Courses Enrolled']);

                $users = User::withCount('userCourses')->orderByDesc('created_at')->get();
                foreach ($users as $u) {
                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        ucfirst(str_replace('_', ' ', $u->role)),
                        $u->is_blocked ? 'Blocked' : 'Active',
                        $u->created_at ? $u->created_at->format('Y-m-d H:i') : '',
                        $u->user_courses_count,
                    ]);
                }
            } else {
                // Default: Orders & Revenue
                fputcsv($handle, ['Order ID', 'Date', 'Buyer Name', 'Email', 'Package', 'Amount (INR)', 'Payment Status', 'Payment Method', 'Transaction ID', 'Invoice No']);

                $orders = Order::whereBetween('created_at', [$start, $end])->orderByDesc('created_at')->get();
                foreach ($orders as $o) {
                    fputcsv($handle, [
                        $o->order_id,
                        $o->created_at ? $o->created_at->format('Y-m-d H:i') : '',
                        $o->buyer_name,
                        $o->buyer_email,
                        $o->package_name,
                        number_format((float) $o->amount, 2),
                        strtoupper($o->payment_status),
                        strtoupper($o->payment_method ?: 'Cashfree'),
                        $o->transaction_id ?: 'N/A',
                        $o->invoice_number ?: 'N/A',
                    ]);
                }
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');

        return $response;
    }

    /**
     * Export Report to formatted Excel (.xls).
     */
    public function exportExcel(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);
        $type = $request->query('type', 'revenue');
        $fileName = 'skilllearner_'.$type.'_report_'.date('Y-m-d').'.xls';

        $orders = [];
        $courses = [];
        $mentors = [];
        $users = [];

        if ($type === 'courses') {
            $courses = Course::leftJoin('user_courses', 'courses.id', '=', 'user_courses.course_id')
                ->select(
                    'courses.title',
                    'courses.category',
                    'courses.price',
                    DB::raw('COUNT(user_courses.id) as total_enrolled'),
                    DB::raw('COUNT(CASE WHEN user_courses.progress_percent = 100 THEN 1 END) as completed_count'),
                    DB::raw('COALESCE(AVG(user_courses.progress_percent), 0) as avg_progress')
                )
                ->groupBy('courses.id', 'courses.title', 'courses.category', 'courses.price')
                ->orderByDesc('total_enrolled')
                ->get();
        } elseif ($type === 'mentors') {
            $mentors = Mentor::all();
        } elseif ($type === 'users') {
            $users = User::withCount('userCourses')->orderByDesc('created_at')->get();
        } else {
            $orders = Order::whereBetween('created_at', [$start, $end])->orderByDesc('created_at')->get();
        }

        $html = view('admin.reports.excel-export', compact(
            'type',
            'rangeLabel',
            'start',
            'end',
            'orders',
            'courses',
            'mentors',
            'users'
        ))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }

    /**
     * Printable PDF / Executive Summary Report View.
     */
    public function printable(Request $request)
    {
        [$start, $end, $range, $rangeLabel] = $this->getDateRange($request);
        $type = $request->query('type', 'summary');

        // General KPI aggregates
        $grossRevenue = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $refundedAmount = (float) Order::where(function ($q) {
            $q->where('payment_status', 'refunded')->orWhere('refund_status', 'approved');
        })->whereBetween('created_at', [$start, $end])->sum('refund_amount');

        $netRevenue = max(0, $grossRevenue - $refundedAmount);
        $paidCount = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->count();
        $totalUsers = User::count();
        $newUsers = User::whereBetween('created_at', [$start, $end])->count();
        $totalEnrollments = UserCourse::count();
        $completedEnrollments = UserCourse::where('progress_percent', 100)->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0;

        $orders = Order::whereBetween('created_at', [$start, $end])->orderByDesc('created_at')->limit(50)->get();
        $topCourses = Course::leftJoin('user_courses', 'courses.id', '=', 'user_courses.course_id')
            ->select('courses.title', 'courses.category', DB::raw('COUNT(user_courses.id) as enrolled'), DB::raw('COALESCE(AVG(user_courses.progress_percent), 0) as progress'))
            ->groupBy('courses.id', 'courses.title', 'courses.category')
            ->orderByDesc('enrolled')
            ->limit(10)
            ->get();
        $mentors = Mentor::all();

        return view('admin.reports.printable', compact(
            'type',
            'start',
            'end',
            'range',
            'rangeLabel',
            'grossRevenue',
            'refundedAmount',
            'netRevenue',
            'paidCount',
            'totalUsers',
            'newUsers',
            'totalEnrollments',
            'completionRate',
            'orders',
            'topCourses',
            'mentors'
        ));
    }
}
