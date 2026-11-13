<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request and render branded maintenance screen if enabled.
     */
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = (string) Setting::get('maintenance_mode', '0') === '1';

        if (! $isMaintenance) {
            return $next($request);
        }

        // Allow authenticated Super Admin users to bypass
        if (Auth::check()) {
            $userRole = Auth::user()->role;
            if ($userRole === 'super_admin' || Auth::user()->isStaff()) {
                return $next($request);
            }
        }

        // Allow backend administrative and authentication routes
        if ($request->is('admin*') || $request->is('login') || $request->is('logout') || $request->is('up')) {
            return $next($request);
        }

        // Allow secret bypass key via URL parameter (e.g. ?bypass=SECRET_KEY)
        $bypassKey = (string) Setting::get('maintenance_bypass_key', 'skl-admin-bypass');
        if (! empty($bypassKey) && $request->query('bypass') === $bypassKey) {
            session(['maintenance_bypass' => true]);

            return $next($request);
        }

        // Allow session with verified bypass
        if (session('maintenance_bypass') === true) {
            return $next($request);
        }

        // Render stylish SkillLearner Maintenance Mode Page with HTTP 503
        return response()->view('errors.maintenance', [
            'title' => Setting::get('maintenance_title', 'Scheduled Platform Maintenance in Progress'),
            'message' => Setting::get('maintenance_message', 'We are currently upgrading our platform infrastructure to deliver a faster and smoother learning experience. We will be back online shortly!'),
            'endTime' => Setting::get('maintenance_end_time', 'Shortly'),
            'contactEmail' => Setting::get('contact_email', 'support@skilllearner.org'),
            'contactPhone' => Setting::get('contact_phone', '+91 98765 43210'),
            'contactWhatsapp' => Setting::get('contact_whatsapp', '+91 98765 43210'),
            'siteName' => Setting::get('site_name', 'SkillLearner'),
            'siteLogo' => Setting::get('site_logo', 'assets/logo.png'),
        ], 503);
    }
}

