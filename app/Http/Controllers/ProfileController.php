<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.profile', [
            'active' => 'profile',
        ]);
    }

    public function update(Request $request)
    {
        PortalDataService::ensureUserSession();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $validated['name'];
            if (! empty($validated['phone'])) {
                $user->phone = $validated['phone'];
            }
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = '/storage/'.$path;
            }
            $user->save();
        }

        $sessionUser = session('user', []);
        $sessionUser['name'] = $validated['name'];
        if (! empty($validated['phone'])) {
            $sessionUser['phone'] = $validated['phone'];
        }
        if (isset($validated['instagram'])) {
            $sessionUser['instagram'] = $validated['instagram'];
        }
        if ($request->hasFile('avatar') && isset($path)) {
            $sessionUser['avatar'] = '/storage/'.$path;
        }
        session(['user' => $sessionUser]);

        return redirect()->back()->with('success', 'Profile details updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if ($user) {
            if (! Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
