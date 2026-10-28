<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\KycVerification;
use App\Models\Payout;
use App\Models\User;
use App\Services\PortalDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display User Management screen (Super Admin & Admin).
     */
    public function users(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $roleFilter = $request->query('role');
        $search = trim((string) $request->query('search', ''));

        $query = User::query()->latest();

        if ($roleFilter && in_array($roleFilter, ['super_admin', 'admin', 'user'])) {
            if ($roleFilter === 'user') {
                $query->whereIn('role', ['user', 'affiliate', 'student']);
            } else {
                $query->where('role', $roleFilter);
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
        ];

        return view('admin.users', [
            'users' => $users,
            'counts' => $counts,
            'currentFilter' => $roleFilter ?? 'all',
            'search' => $search,
            'active' => 'admin-users',
        ]);
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
            'status' => ['required', 'in:Transferred,Processing,Rejected'],
        ]);

        $payout->update([
            'status' => $validated['status'],
            'processed_at' => $validated['status'] === 'Transferred' ? now() : null,
        ]);

        return back()->with('success', "Payout #{$payout->payout_code} status updated to {$validated['status']}.");
    }

    /**
     * Platform & System Settings (Super Admin Only).
     */
    public function settings(Request $request): View
    {
        PortalDataService::ensureUserSession();

        return view('admin.settings', [
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
        ]);

        session(['platform_settings' => $validated]);

        return back()->with('success', 'Platform settings updated successfully by Super Admin.');
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
}
