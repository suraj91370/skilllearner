<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check() && ! session()->has('user')) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();
        $userRole = $user?->role ?? session('user.role', 'user');

        // Normalize role: affiliate/student are equivalent to user
        if (in_array($userRole, ['affiliate', 'student'])) {
            $userRole = 'user';
        }

        // Super Admin has universal bypass
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // If no specific roles required, allow through
        if (empty($roles)) {
            return $next($request);
        }

        foreach ($roles as $allowedRole) {
            $normalizedAllowed = in_array($allowedRole, ['affiliate', 'student']) ? 'user' : $allowedRole;
            if ($userRole === $normalizedAllowed) {
                return $next($request);
            }
        }

        return redirect()->route('portal.courses')->with('error', 'Access restricted: You do not have permission to view that section.');
    }
}
