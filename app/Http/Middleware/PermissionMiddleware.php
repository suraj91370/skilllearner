<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request by verifying module-level RBAC permission.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module, string $action = 'view'): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = Auth::user();

        // 1. Super Admin has universal access
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // 2. Check if user is staff and has the specific module & action permission
        if ($user->hasPermission($module, $action)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => "Permission Denied: Aapke paas '{$module}' module me '{$action}' karne ki permission nahi hai.",
            ], 403);
        }

        return redirect()->route('admin.dashboard')->with('error', "⚠️ Access Restricted: Aapke paas '{$module}' module ({$action}) access karne ki permission nahi hai. Kripya Super Admin se sampark karein.");
    }
}

