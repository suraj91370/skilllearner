<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() || session()->has('user')) {
            return redirect()->route('portal.courses');
        }

        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = trim((string) $request->input('username'));
        $password = (string) $request->input('password');
        $remember = $request->boolean('remember');

        // Determine if input is email, phone, or affiliate ID
        $field = 'email';
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } elseif (preg_match('/^[0-9+\s\-]{7,20}$/', $username)) {
            $field = 'phone';
        } elseif (str_starts_with(strtoupper($username), 'SL-') || str_starts_with(strtoupper($username), 'SKL-')) {
            $field = 'affiliate_id';
        } else {
            // Check if matches existing user email prefix or exact match
            $matchedUser = User::where('email', $username)
                ->orWhere('affiliate_id', $username)
                ->orWhere('phone', $username)
                ->first();

            if ($matchedUser) {
                $field = 'email';
                $username = $matchedUser->email;
            }
        }

        $credentials = [$field => $username, 'password' => $password];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            $this->syncUserSession($user);

            return redirect()->intended('/my-courses')->with('alert', 'welcome');
        }

        return back()
            ->withInput($request->only('username', 'remember'))
            ->with('error', 'Invalid username/email or password. Please try again.');
    }

    /**
     * Display the registration page.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('portal.courses');
        }

        return view('register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6'],
            'package' => ['nullable', 'string', 'max:100'],
            'sponsor_id' => ['nullable', 'string', 'max:50'],
        ]);

        // Generate unique affiliate ID
        $affiliateId = 'SKL-'.rand(1000, 9999);
        while (User::where('affiliate_id', $affiliateId)->exists()) {
            $affiliateId = 'SKL-'.rand(1000, 9999);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'affiliate_id' => $affiliateId,
            'sponsor_id' => $validated['sponsor_id'] ?? 'SL-ADMIN',
            'active_package' => $validated['package'] ?? 'Advance Package',
            'wallet_balance' => 0.00,
            'today_earning' => 0.00,
            'weekly_earning' => 0.00,
            'total_earning' => 0.00,
            'kyc_status' => 'Pending Verification',
            'avatar' => null,
            'role' => 'affiliate',
        ]);

        // Automatically enroll the user into all default course tracks
        $courses = Course::all();
        foreach ($courses as $course) {
            UserCourse::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'progress_percent' => 0,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $this->syncUserSession($user);

        return redirect()->route('portal.courses')->with('alert', 'welcome');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('info', 'You have been logged out successfully.');
    }

    /**
     * Sync user details into session for backward compatibility with existing Blade templates.
     */
    private function syncUserSession(User $user): void
    {
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '+91 98765 43210',
            'affiliate_id' => $user->affiliate_id ?? 'SL-'.$user->id,
            'sponsor_id' => $user->sponsor_id ?? 'SL-ADMIN',
            'active_package' => $user->active_package ?? 'Advance Package',
            'wallet_balance' => (float) $user->wallet_balance,
            'today_earning' => (float) $user->today_earning,
            'weekly_earning' => (float) $user->weekly_earning,
            'total_earning' => (float) $user->total_earning,
            'kyc_status' => $user->kyc_status ?? 'Verified ✅',
            'avatar' => $user->avatar,
            'role' => $user->role ?? 'affiliate',
        ]]);
    }
}
