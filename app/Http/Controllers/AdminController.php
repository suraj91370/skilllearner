<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Course;
use App\Models\KycVerification;
use App\Models\Mentor;
use App\Models\MentorPayout;
use App\Models\OfferRedemption;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserCourse;
use App\Services\CashfreeService;
use App\Services\CommissionService;
use App\Services\PortalDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class AdminController extends Controller
{
    /**
     * Super Admin & Admin Executive Dashboard with Platform Revenue, Active/Passive breakdown, and Commission Approvals.
     */
    public function dashboard(Request $request): View
    {
        PortalDataService::ensureUserSession();

        // Self-heal any zero-amount commissions in the database automatically
        try {
            $zeroComms = Commission::where('amount', '<=', 0)->get();
            foreach ($zeroComms as $zc) {
                if (! empty($zc->package_name)) {
                    $pkg = CommissionService::getPackageInfo($zc->package_name);
                    $isPassive = str_contains(strtolower((string) $zc->commission_type), 'passive');
                    $correctAmount = $isPassive ? (float) $pkg['passive_income'] : (float) $pkg['active_income'];

                    // Cap commission to affiliate's own active package tier
                    if ($zc->user && ! empty($zc->user->active_package)) {
                        $userPkg = CommissionService::getPackageInfo($zc->user->active_package);
                        $userMax = $isPassive ? (float) ($userPkg['passive_income'] ?? $correctAmount) : (float) ($userPkg['active_income'] ?? $correctAmount);
                        $correctAmount = min($correctAmount, $userMax);
                    }

                    if ($correctAmount > 0) {
                        $diff = $correctAmount - (float) $zc->amount;
                        $zc->update(['amount' => $correctAmount]);

                        // If already marked Credited, credit the difference into the affiliate's wallet
                        if ($zc->status === 'Credited' && $zc->user && $diff > 0) {
                            CommissionService::creditUserEarnings($zc->user, $diff, $isPassive);
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            // Ignore error
        }

        $stats = CommissionService::getPlatformRevenueStats();

        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = Commission::with('user')->latest();

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', ucfirst($statusFilter));
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('affiliate_id', 'like', "%{$search}%");
                    });
            });
        }

        $commissions = $query->paginate(20)->withQueryString();

        $counts = [
            'total' => Commission::count(),
            'pending' => Commission::where('status', 'Pending')->count(),
            'credited' => Commission::where('status', 'Credited')->count(),
            'rejected' => Commission::where('status', 'Rejected')->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'commissions' => $commissions,
            'counts' => $counts,
            'currentFilter' => $statusFilter,
            'search' => $search,
            'active' => 'admin-dashboard',
        ]);
    }

    /**
     * Approve and verify payment for a pending commission.
     */
    public function approveCommission(Request $request, Commission $commission): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can verify payments and approve commissions.');
        }

        $success = CommissionService::creditApprovedCommission($commission);

        if ($success) {
            // Also activate the student/buyer's account so they can log in
            $buyerCleanName = explode(' (via', $commission->buyer_name)[0];
            $buyerUser = User::where('name', $buyerCleanName)
                ->orWhere('name', 'like', "%{$buyerCleanName}%")
                ->first();
            if ($buyerUser && $buyerUser->payment_status !== 'paid') {
                $buyerUser->update(['payment_status' => 'paid']);
            }

            $affiliateName = $commission->user?->name ?? 'Affiliate';

            return back()->with('success', "✅ Payment verified! Account for {$buyerCleanName} has been activated, and ₹".number_format($commission->amount)." successfully credited to {$affiliateName}'s wallet.");
        }

        return back()->with('info', "Commission #{$commission->id} was already credited.");
    }

    /**
     * Reject a pending commission.
     */
    public function rejectCommission(Request $request, Commission $commission): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can reject commissions.');
        }

        CommissionService::rejectCommission($commission, $request->input('reason'));

        return back()->with('info', "❌ Commission #{$commission->id} marked as Rejected. No wallet balance was added.");
    }

    /**
     * Display User Management screen (Super Admin & Admin).
     */
    public function users(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $roleFilter = $request->query('role');
        $statusFilter = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        $query = User::query()->withCount('userCourses')->latest();

        if ($roleFilter && in_array($roleFilter, ['super_admin', 'admin', 'user'])) {
            if ($roleFilter === 'user') {
                $query->whereIn('role', ['user', 'affiliate', 'student']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        if ($statusFilter) {
            if ($statusFilter === 'blocked') {
                $query->where('is_blocked', true);
            } elseif ($statusFilter === 'pending') {
                $query->where('payment_status', 'pending');
            } elseif ($statusFilter === 'active') {
                $query->where('is_blocked', false)->where('payment_status', 'paid');
            }
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('affiliate_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        $counts = [
            'total' => User::count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'user' => User::whereIn('role', ['user', 'affiliate', 'student'])->count(),
            'blocked' => User::where('is_blocked', true)->count(),
            'pending' => User::where('payment_status', 'pending')->count(),
        ];

        return view('admin.users', [
            'users' => $users,
            'counts' => $counts,
            'currentFilter' => $roleFilter ?? ($statusFilter ?? 'all'),
            'search' => $search,
            'active' => 'admin-users',
        ]);
    }

    /**
     * Show full profile, course progress, certificates, and financials for a specific user.
     */
    public function showUser(Request $request, User $user): View|JsonResponse
    {
        PortalDataService::ensureUserSession();

        $user->loadMissing(['commissions', 'payouts', 'kyc']);

        $allCourses = Course::where('is_visible', true)->get();
        $userCourses = UserCourse::where('user_id', $user->id)->get()->keyBy('course_id');
        $sponsor = User::where('affiliate_id', $user->sponsor_id)
            ->orWhere('email', $user->sponsor_id)
            ->first();

        // Count completed certificates (courses with progress = 100%)
        $completedCoursesCount = $userCourses->where('progress_percent', '>=', 100)->count();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'user' => $user,
                'sponsor' => $sponsor,
                'courses' => $allCourses->map(function ($c) use ($userCourses) {
                    $uc = $userCourses->get($c->id);

                    return [
                        'id' => $c->id,
                        'title' => $c->title,
                        'package' => $c->package,
                        'is_enrolled' => ! empty($uc),
                        'progress_percent' => $uc?->progress_percent ?? 0,
                        'completed_at' => $uc?->completed_at?->format('d M, Y H:i'),
                        'certificate_id' => ! empty($uc) && $uc->progress_percent >= 100 ? 'SL-CERT-'.(1000 + $c->id).'-'.$uc->user_id : null,
                    ];
                }),
                'completed_count' => $completedCoursesCount,
            ]);
        }

        return view('admin.user-detail', [
            'user' => $user,
            'sponsor' => $sponsor,
            'allCourses' => $allCourses,
            'userCourses' => $userCourses,
            'completedCoursesCount' => $completedCoursesCount,
            'active' => 'admin-users',
        ]);
    }

    /**
     * Toggle Block / Unblock user account (Super Admin / Admin).
     */
    public function toggleUserBlock(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can block or unblock accounts.');
        }

        if ($user->id === $currentUser?->id) {
            return back()->with('error', 'Aap apna khud ka account block nahi kar sakte.');
        }

        if ($user->role === 'super_admin' && $currentRole !== 'super_admin') {
            return back()->with('error', 'Only another Super Admin can manage a Super Admin account.');
        }

        $newBlockStatus = ! $user->is_blocked;
        $user->update(['is_blocked' => $newBlockStatus]);

        $message = $newBlockStatus
            ? "🔒 User '{$user->name}' ko successfully BLOCK kar diya gaya hai. Ab yeh login nahi kar sakega."
            : "🔓 User '{$user->name}' ko successfully UNBLOCK kar diya gaya hai. Ab yeh normal login kar sakega.";

        return back()->with('success', $message);
    }

    /**
     * Reset user password manually from admin panel.
     */
    public function resetUserPassword(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can reset user passwords.');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $newPassword = (string) $validated['password'];
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return back()->with('success', "🔑 Password for '{$user->name}' has been successfully reset to: {$newPassword}");
    }

    /**
     * One-click Account & Payment Verification (Admin).
     */
    public function verifyUserAccount(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can verify accounts.');
        }

        $user->update([
            'payment_status' => 'paid',
            'kyc_status' => 'Verified',
            'is_blocked' => false,
        ]);

        // Auto unlock courses for the user
        $courses = Course::all();
        foreach ($courses as $c) {
            UserCourse::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $c->id,
            ], [
                'progress_percent' => 0,
            ]);
        }

        // Credit any pending commissions for this buyer
        $pendingComms = Commission::where('buyer_name', 'like', "%{$user->name}%")
            ->where('status', 'Pending')
            ->get();
        foreach ($pendingComms as $comm) {
            CommissionService::creditApprovedCommission($comm);
        }

        return back()->with('success', "✅ User '{$user->name}' has been fully verified and activated! ID active ho gayi hai aur sabhi courses unlock ho gaye hain.");
    }

    /**
     * Manually enroll a user into a specific course.
     */
    public function enrollCourse(Request $request, User $user): RedirectResponse|JsonResponse
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $courseId = (int) $request->input('course_id');
        $course = Course::findOrFail($courseId);

        UserCourse::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'progress_percent' => 0,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => "Enrolled in {$course->title}"]);
        }

        return back()->with('success', "🎓 '{$user->name}' ko '{$course->title}' course me manually enroll kar diya gaya hai.");
    }

    /**
     * Manually unenroll a user from a specific course.
     */
    public function unenrollCourse(Request $request, User $user): RedirectResponse|JsonResponse
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $courseId = (int) $request->input('course_id');
        $course = Course::findOrFail($courseId);

        UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => "Unenrolled from {$course->title}"]);
        }

        return back()->with('success', "❌ '{$user->name}' ko '{$course->title}' course se unenroll kar diya gaya hai.");
    }

    /**
     * Manually update a user's course progress (and issue certificate on 100%).
     */
    public function updateCourseProgress(Request $request, User $user): RedirectResponse|JsonResponse
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'progress_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $courseId = (int) $request->input('course_id');
        $percent = (int) $request->input('progress_percent');
        $course = Course::findOrFail($courseId);

        $userCourse = UserCourse::updateOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'progress_percent' => $percent,
            'completed_at' => $percent >= 100 ? now() : null,
        ]);

        $certMsg = $percent >= 100 ? ' (Course 100% complete! Certificate has been generated 🎖️)' : '';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'progress_percent' => $percent,
                'completed_at' => $userCourse->completed_at?->format('d M, Y H:i'),
                'certificate_id' => $percent >= 100 ? 'SL-CERT-'.(1000 + $course->id).'-'.$user->id : null,
                'message' => "Progress updated to {$percent}%{$certMsg}",
            ]);
        }

        return back()->with('success', "📈 '{$user->name}' ka '{$course->title}' me progress {$percent}% set ho gaya hai{$certMsg}.");
    }

    /**
     * Update user role (Super Admin only).
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if ($currentRole !== 'super_admin') {
            return back()->with('error', 'Only Super Admins have permission to modify user roles.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:super_admin,admin,user'],
        ]);

        // Prevent self-demotion if the current user is the target
        if ($user->id === $currentUser?->id && $validated['role'] !== 'super_admin') {
            return back()->with('error', 'You cannot demote your own Super Admin account.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role for {$user->name} has been updated to ".ucwords(str_replace('_', ' ', $validated['role'])).'.');
    }

    /**
     * Toggle user payment / account activation status (Admin only).
     */
    public function toggleUserPaymentStatus(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can verify payments.');
        }

        $newStatus = $user->payment_status === 'paid' ? 'pending' : 'paid';
        $user->update(['payment_status' => $newStatus]);

        if ($newStatus === 'paid') {
            $pendingComms = Commission::where('buyer_name', 'like', "%{$user->name}%")
                ->where('status', 'Pending')
                ->get();
            foreach ($pendingComms as $comm) {
                CommissionService::creditApprovedCommission($comm);
            }
        }

        $statusLabel = $newStatus === 'paid' ? 'Paid & Active (User can now log in)' : 'Pending Payment (Login Blocked)';

        return back()->with('success', "Payment status for {$user->name} updated to {$statusLabel}.");
    }

    /**
     * Update a user's Industry Revenue (Super Admin / Admin).
     */
    public function updateIndustryRevenue(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can update Industry Revenue.');
        }

        $validated = $request->validate([
            'industry_revenue' => ['required', 'numeric', 'min:0'],
        ]);

        $newAmount = (float) $validated['industry_revenue'];
        $user->update(['industry_revenue' => $newAmount]);

        // If currently logged in as this user or in session, update session too
        if (session('user.id') === $user->id) {
            session(['user.industry_revenue' => $newAmount]);
        }

        return back()->with('success', "Industry Revenue for {$user->name} successfully updated to ₹".number_format($newAmount, 2).'.');
    }

    /**
     * Permanently hard delete a user and ALL their associated data (Super Admin Only).
     */
    public function deleteUser(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if ($currentRole !== 'super_admin') {
            return back()->with('error', 'Only Super Admins have permission to permanently delete users.');
        }

        if ($user->id === $currentUser?->id) {
            return back()->with('error', 'Security Violation: You cannot delete your own Super Admin account.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $userAffiliateId = $user->affiliate_id;

        DB::transaction(function () use ($user) {
            $userId = $user->id;
            $userEmail = $user->email;

            // 1. Delete all commissions for this user
            Commission::where('user_id', $userId)->delete();

            // 2. Delete all payouts
            Payout::where('user_id', $userId)->delete();

            // 3. Delete KYC verification records and documents
            $kyc = KycVerification::where('user_id', $userId)->first();
            if ($kyc) {
                if (! empty($kyc->document_path) && file_exists(public_path($kyc->document_path))) {
                    @unlink(public_path($kyc->document_path));
                }
                $kyc->delete();
            }

            // 4. Delete enrolled courses and course progress
            UserCourse::where('user_id', $userId)->delete();

            // 5. Delete coupon/offer redemptions
            OfferRedemption::where('user_id', $userId)->delete();

            // 6. Delete mentor profile & payouts if user is a mentor
            $mentors = Mentor::where('user_id', $userId)->get();
            foreach ($mentors as $mentor) {
                MentorPayout::where('mentor_id', $mentor->id)->delete();
                if (! empty($mentor->photo) && file_exists(public_path($mentor->photo))) {
                    @unlink(public_path($mentor->photo));
                }
                $mentor->delete();
            }

            // 7. Delete password reset tokens
            if (! empty($userEmail)) {
                DB::table('password_reset_tokens')->where('email', $userEmail)->delete();
            }

            // 8. Delete active session records if database session driver is used
            try {
                if (Schema::hasTable('sessions')) {
                    DB::table('sessions')->where('user_id', $userId)->delete();
                }
            } catch (Throwable) {
                // Ignore if sessions table does not exist or driver is file/cookie
            }

            // 9. Clean up avatar file if stored locally in public
            if (! empty($user->avatar) && str_starts_with($user->avatar, 'uploads/') && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            // 10. Hard delete the user record itself
            $user->delete();
        });

        return back()->with('success', "User '{$userName}' ({$userEmail} | ID: {$userAffiliateId}) and ALL associated data have been permanently hard deleted.");
    }

    /**
     * Display KYC Approvals queue (Super Admin & Admin).
     */
    public function kycRequests(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $statusFilter = $request->query('status', 'all');

        $query = KycVerification::with('user')->latest();
        if ($statusFilter !== 'all') {
            $query->where('status', ucfirst($statusFilter));
        }

        $kycList = $query->get();

        return view('admin.kyc-requests', [
            'kycList' => $kycList,
            'currentFilter' => $statusFilter,
            'active' => 'admin-kyc',
        ]);
    }

    /**
     * Approve a user's KYC verification.
     */
    public function approveKyc(Request $request, KycVerification $kyc): RedirectResponse
    {
        $kyc->update([
            'status' => 'Verified',
            'remarks' => 'Approved by '.session('user.name', 'Admin').' on '.now()->format('d M Y, h:i A'),
        ]);

        if ($kyc->user) {
            $kyc->user->update(['kyc_status' => 'Verified ✅']);
        }

        return back()->with('success', "KYC for {$kyc->user?->name} approved successfully!");
    }

    /**
     * Reject a user's KYC verification.
     */
    public function rejectKyc(Request $request, KycVerification $kyc): RedirectResponse
    {
        $reason = $request->input('reason', 'Document details unclear or mismatched.');

        $kyc->update([
            'status' => 'Rejected',
            'remarks' => 'Rejected: '.$reason,
        ]);

        if ($kyc->user) {
            $kyc->user->update(['kyc_status' => 'Rejected ❌']);
        }

        return back()->with('info', "KYC for {$kyc->user?->name} marked as Rejected.");
    }

    /**
     * Display Payout requests queue (Super Admin & Admin).
     */
    public function payoutRequests(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $statusFilter = $request->query('status', 'all');

        $query = Payout::with('user')->latest();
        if ($statusFilter !== 'all') {
            $query->where('status', ucfirst($statusFilter));
        }

        $payouts = $query->get();

        $stats = [
            'total_paid' => Payout::where('status', 'Transferred')->sum('amount'),
            'pending_amount' => Payout::where('status', 'Processing')->orWhere('status', 'Pending')->sum('amount'),
            'total_requests' => Payout::count(),
        ];

        return view('admin.payout-requests', [
            'payouts' => $payouts,
            'stats' => $stats,
            'currentFilter' => $statusFilter,
            'active' => 'admin-payouts',
        ]);
    }

    /**
     * Update payout request status (Mark transferred or hold).
     */
    public function updatePayoutStatus(Request $request, Payout $payout): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Transferred,Processing,Rejected,Approved'],
        ]);

        $newStatus = $validated['status'] === 'Approved' ? 'Transferred' : $validated['status'];
        $oldStatus = $payout->status;

        // If rejecting a pending or processing request, refund amount to user wallet
        if ($newStatus === 'Rejected' && in_array($oldStatus, ['Pending', 'Processing'])) {
            if ($payout->user) {
                $payout->user->increment('wallet_balance', $payout->amount);
            }
        }

        // If re-approving a rejected request, re-deduct if funds exist
        if ($newStatus === 'Transferred' && $oldStatus === 'Rejected') {
            if ($payout->user && $payout->user->wallet_balance >= $payout->amount) {
                $payout->user->decrement('wallet_balance', $payout->amount);
            }
        }

        $payout->update([
            'status' => $newStatus,
            'processed_at' => $newStatus === 'Transferred' ? now() : null,
        ]);

        // Refresh user session if modifying the current logged-in user
        if (Auth::id() === $payout->user_id) {
            PortalDataService::ensureUserSession();
        }

        $message = match ($newStatus) {
            'Transferred' => "Payout #{$payout->payout_code} (₹".number_format($payout->amount).') approved and marked as Transferred! ✅',
            'Rejected' => "Payout #{$payout->payout_code} rejected. ₹".number_format($payout->amount).' refunded to affiliate wallet. ❌',
            default => "Payout #{$payout->payout_code} status updated to {$newStatus}.",
        };

        return back()->with('success', $message);
    }

    /**
     * Platform & System Settings (Super Admin Only).
     */
    public function settings(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $settings = Setting::allSettings();

        return view('admin.settings', [
            'settings' => $settings,
            'active' => 'admin-settings',
        ]);
    }

    /**
     * Save Platform Settings (Super Admin Only).
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform_name' => ['required', 'string', 'max:100'],
            'tier1_commission' => ['required', 'numeric', 'min:0', 'max:100'],
            'tier2_commission' => ['required', 'numeric', 'min:0', 'max:100'],
            'min_payout_amount' => ['required', 'numeric', 'min:100'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'login_video_url' => ['nullable', 'string', 'max:500'],
            'login_video_title' => ['nullable', 'string', 'max:255'],
            'login_video_description' => ['nullable', 'string', 'max:1000'],
            'login_video_enabled' => ['nullable', 'boolean'],
        ]);

        $loginVideoEnabled = $request->has('login_video_enabled') ? '1' : '0';

        Setting::set('platform_name', $validated['platform_name']);
        Setting::set('tier1_commission', $validated['tier1_commission']);
        Setting::set('tier2_commission', $validated['tier2_commission']);
        Setting::set('min_payout_amount', $validated['min_payout_amount']);
        Setting::set('login_video_url', $validated['login_video_url'] ?? '');
        Setting::set('login_video_title', $validated['login_video_title'] ?? 'Welcome to SkillLearner! Watch This First');
        Setting::set('login_video_description', $validated['login_video_description'] ?? '');
        Setting::set('login_video_enabled', $loginVideoEnabled);

        $allSettings = Setting::allSettings();
        session(['platform_settings' => $allSettings]);

        return back()->with('success', 'Platform settings and Login Video updated successfully by Super Admin.');
    }

    /**
     * Display Course Management and Show/Hide control (Super Admin Only).
     */
    public function courses(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $filter = $request->query('filter', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = Course::query()->latest();

        if ($filter === 'visible') {
            $query->where('is_visible', true);
        } elseif ($filter === 'hidden') {
            $query->where('is_visible', false);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('instructor', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%");
            });
        }

        $courses = $query->get();

        $counts = [
            'total' => Course::count(),
            'visible' => Course::where('is_visible', true)->count(),
            'hidden' => Course::where('is_visible', false)->count(),
        ];

        return view('admin.courses', [
            'courses' => $courses,
            'counts' => $counts,
            'currentFilter' => $filter,
            'search' => $search,
            'active' => 'admin-courses',
        ]);
    }

    /**
     * Toggle Show / Hide visibility of a Course for users (Super Admin Only).
     */
    public function toggleCourseVisibility(Request $request, Course $course): JsonResponse|RedirectResponse
    {
        $newStatus = ! $course->is_visible;
        $course->update(['is_visible' => $newStatus]);

        $statusText = $newStatus ? 'Visible to Users (Shown in My Course)' : 'Hidden from Users (Removed from My Course)';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'course_id' => $course->id,
                'is_visible' => $newStatus,
                'status_text' => $statusText,
                'message' => "Course '{$course->title}' is now {$statusText}.",
            ]);
        }

        return back()->with('success', "Course '{$course->title}' is now {$statusText}.");
    }

    /**
     * All Orders, Transactions & Refund Management Dashboard (Super Admin & Admin).
     */
    public function orders(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $statusFilter = $request->query('status'); // all, paid, pending, failed, refunded
        $methodFilter = $request->query('method'); // cashfree, manual_upi
        $search = trim((string) $request->query('search', ''));

        $query = Order::query()->with('user')->latest();

        if ($statusFilter && in_array($statusFilter, ['paid', 'pending', 'failed', 'refunded'])) {
            $query->where('payment_status', $statusFilter);
        }

        if ($methodFilter && in_array($methodFilter, ['cashfree', 'manual_upi'])) {
            $query->where('payment_method', $methodFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhere('buyer_name', 'like', "%{$search}%")
                    ->orWhere('buyer_email', 'like', "%{$search}%")
                    ->orWhere('buyer_phone', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(25)->withQueryString();

        $today = now()->startOfDay();
        $metrics = [
            'total_orders' => Order::count(),
            'total_revenue' => (float) Order::where('payment_status', 'paid')->sum('amount'),
            'today_revenue' => (float) Order::where('payment_status', 'paid')->where('created_at', '>=', $today)->sum('amount'),
            'paid_count' => Order::where('payment_status', 'paid')->count(),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'failed_count' => Order::where('payment_status', 'failed')->count(),
            'refunded_count' => Order::where('payment_status', 'refunded')->count(),
            'total_refunded' => (float) Order::where('payment_status', 'refunded')->sum('refund_amount'),
        ];

        return view('admin.orders', [
            'orders' => $orders,
            'metrics' => $metrics,
            'currentStatus' => $statusFilter ?? 'all',
            'currentMethod' => $methodFilter ?? 'all',
            'search' => $search,
            'active' => 'admin-orders',
        ]);
    }

    /**
     * Show single Order details (modal / json response).
     */
    public function showOrder(Request $request, Order $order): JsonResponse|View
    {
        $order->loadMissing('user');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'order' => $order,
                'invoice_url' => route('admin.orders.invoice', $order->id),
            ]);
        }

        return view('admin.order-detail', [
            'order' => $order,
            'active' => 'admin-orders',
        ]);
    }

    /**
     * Generate & Download Official Tax Invoice for an Order.
     */
    public function downloadInvoice(Request $request, Order $order): View
    {
        $order->loadMissing('user');

        // Ensure unique tax invoice number
        $order->getOrGenerateInvoiceNumber();

        // Calculate tax breakdown (18% GST standard on online education)
        $totalPaid = (float) $order->amount;
        $taxableValue = round($totalPaid / 1.18, 2);
        $totalGst = round($totalPaid - $taxableValue, 2);
        $cgst = round($totalGst / 2, 2);
        $sgst = round($totalGst - $cgst, 2);

        return view('admin.invoice', [
            'order' => $order,
            'taxableValue' => $taxableValue,
            'totalGst' => $totalGst,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'totalPaid' => $totalPaid,
        ]);
    }

    /**
     * Process Refund Request for an Order (Approve, Reject, or Request).
     */
    public function processRefund(Request $request, Order $order): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins and Super Admins can manage refunds.');
        }

        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject,request'],
            'refund_amount' => ['nullable', 'numeric', 'min:0'],
            'refund_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $action = $validated['action'];
        $amount = (float) ($validated['refund_amount'] ?? $order->amount);
        $reason = trim((string) ($validated['refund_reason'] ?? 'Customer refund request'));

        if ($action === 'approve') {
            $order->update([
                'payment_status' => 'refunded',
                'refund_status' => 'approved',
                'refund_amount' => $amount,
                'refund_reason' => $reason,
                'refunded_at' => now(),
            ]);

            Log::info("💳 [CASHFREE-REFUND] Refund APPROVED for Order #{$order->order_id} (Amount: ₹{$amount}) - Reason: {$reason} by Admin ID #{$currentUser?->id}");

            return back()->with('success', '✅ Refund of ₹'.number_format($amount, 2)." for Order #{$order->order_id} has been APPROVED.");
        }

        if ($action === 'reject') {
            $order->update([
                'refund_status' => 'rejected',
                'refund_reason' => $reason,
            ]);

            Log::info("💳 [CASHFREE-REFUND] Refund REJECTED for Order #{$order->order_id} - Note: {$reason}");

            return back()->with('info', "Refund request for Order #{$order->order_id} has been REJECTED.");
        }

        // action === 'request'
        $order->update([
            'refund_status' => 'requested',
            'refund_amount' => $amount,
            'refund_reason' => $reason,
        ]);

        return back()->with('success', 'Refund request for ₹'.number_format($amount, 2)." submitted for Order #{$order->order_id}.");
    }

    /**
     * Manually mark a Failed or Pending order as Paid (Offline / Manual UPI resolution).
     */
    public function markOrderPaid(Request $request, Order $order): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        if (! in_array($currentRole, ['super_admin', 'admin'])) {
            return back()->with('error', 'Only Admins can verify payments.');
        }

        $transactionId = trim((string) $request->input('transaction_id', $order->transaction_id ?: ('MANUAL_'.time())));

        $order->update([
            'payment_status' => 'paid',
            'transaction_id' => $transactionId,
            'failure_reason' => null,
            'invoice_number' => $order->invoice_number ?: ('INV-SKL-'.date('Y').'-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT)),
        ]);

        // If user account is linked or exists, activate it
        $user = $order->user ?: User::where('email', $order->buyer_email)->first();
        if ($user) {
            $user->update([
                'payment_status' => 'paid',
                'active_package' => $order->package_name,
            ]);

            // Unlock all courses
            $courses = Course::all();
            foreach ($courses as $c) {
                UserCourse::firstOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $c->id,
                ], [
                    'progress_percent' => 0,
                ]);
            }

            // Distribute 2-tier commissions in Credited status
            CommissionService::processSale(
                $order->package_name,
                $user->name,
                $user->sponsor_id ?? 'SL-ADMIN',
                $user,
                initialStatus: 'Credited'
            );
        }

        Log::info("💳 [ORDER-TRACKING] Order #{$order->order_id} manually marked as PAID by Admin #{$currentUser?->id}. Transaction: {$transactionId}");

        return back()->with('success', "✅ Order #{$order->order_id} has been marked as PAID! Account activated and courses unlocked.");
    }

    /**
     * Cashfree Payment Gateway Settings Screen (Super Admin Only).
     */
    public function paymentGatewaySettings(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $appId = CashfreeService::getAppId();
        $secretKey = CashfreeService::getSecretKey();
        $env = CashfreeService::getEnv();

        return view('admin.payment-gateway', [
            'appId' => $appId,
            'secretKey' => $secretKey,
            'env' => $env,
            'isConfigured' => CashfreeService::isConfigured(),
            'webhookUrl' => url('/payment/cashfree/webhook'),
            'returnUrl' => url('/payment/cashfree/callback'),
            'active' => 'admin-payment-gateway',
        ]);
    }

    /**
     * Save Cashfree Payment Gateway Credentials & Settings (Super Admin Only).
     */
    public function updatePaymentGatewaySettings(Request $request): RedirectResponse
    {
        $currentUser = Auth::user();
        if (($currentUser?->role ?? session('user.role')) !== 'super_admin') {
            return back()->with('error', 'Only Super Admins have permission to modify payment gateway settings.');
        }

        $validated = $request->validate([
            'cashfree_env' => ['required', 'in:sandbox,production'],
            'cashfree_app_id' => ['nullable', 'string', 'max:255'],
            'cashfree_secret_key' => ['nullable', 'string', 'max:255'],
        ]);

        Setting::set('cashfree_env', $validated['cashfree_env']);
        if (isset($validated['cashfree_app_id'])) {
            Setting::set('cashfree_app_id', trim((string) $validated['cashfree_app_id']));
        }
        if (! empty($validated['cashfree_secret_key'])) {
            Setting::set('cashfree_secret_key', trim((string) $validated['cashfree_secret_key']));
        }

        Log::info("💳 [CASHFREE-SETTINGS] Super Admin updated Payment Gateway settings. Mode: {$validated['cashfree_env']}");

        return back()->with('success', '✅ Cashfree Payment Gateway settings successfully saved!');
    }

    /**
     * Test live connectivity to Cashfree with provided or saved credentials.
     */
    public function testPaymentGatewayConnection(Request $request): JsonResponse|RedirectResponse
    {
        $appId = $request->input('cashfree_app_id');
        $secret = $request->input('cashfree_secret_key');
        $env = $request->input('cashfree_env');

        $result = CashfreeService::testConnection($appId, $secret, $env);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
