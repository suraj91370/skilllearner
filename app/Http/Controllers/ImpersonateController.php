<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PortalDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Impersonate a user or admin account (Super Admin only).
     */
    public function impersonate(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role ?? session('user.role', 'user');

        // Check if current user is Super Admin or if already impersonating
        $isSuperAdmin = ($currentRole === 'super_admin') || session()->has('impersonated_by');

        if (! $isSuperAdmin) {
            return back()->with('error', 'Only Super Admins can login to other accounts.');
        }

        // Prevent self-impersonation
        if ($currentUser && $currentUser->id === $user->id) {
            return back()->with('error', 'You are already logged into this account.');
        }

        // Store the original Super Admin ID if not already impersonating
        if (! session()->has('impersonated_by')) {
            session()->put('impersonated_by', $currentUser->id);
        }

        $superAdminId = session('impersonated_by');

        // Login as the target user
        Auth::login($user);
        $request->session()->regenerate();

        // Preserve original Super Admin ID across session regeneration
        session()->put('impersonated_by', $superAdminId);

        // Sync target user data into session for portal views
        PortalDataService::ensureUserSession();

        // Redirect appropriately based on the impersonated account's role
        if (in_array($user->role, ['super_admin', 'admin'])) {
            return redirect()->route('admin.users')
                ->with('success', "Logged in as {$user->name} (".ucfirst($user->role).').');
        }

        return redirect()->route('portal.courses')
            ->with('success', "Logged in as student {$user->name}. You are now viewing their student portal.");
    }

    /**
     * Leave impersonation and return to the Super Admin account.
     */
    public function leave(Request $request): RedirectResponse
    {
        if (! session()->has('impersonated_by')) {
            return redirect()->route('portal.courses')
                ->with('error', 'No active impersonation session found.');
        }

        $superAdminId = session()->pull('impersonated_by');
        $superAdmin = User::find($superAdminId);

        if (! $superAdmin) {
            Auth::logout();
            session()->forget('user');

            return redirect()->route('login')
                ->with('error', 'Original Super Admin account not found.');
        }

        // Login back as Super Admin
        Auth::login($superAdmin);
        $request->session()->regenerate();

        // Sync Super Admin session
        PortalDataService::ensureUserSession();

        return redirect()->route('admin.users')
            ->with('success', "Returned to your Super Admin account ({$superAdmin->name}).");
    }
}
