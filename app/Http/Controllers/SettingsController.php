<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'upi_id'       => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_ifsc'    => 'nullable|string|max:20',
            'bank_name'    => 'nullable|string|max:100',
        ]);

        Auth::user()->update($request->only('name', 'upi_id', 'bank_account', 'bank_ifsc', 'bank_name'));
        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully.');
    }

    public function updatePin(Request $request)
    {
        $request->validate(['pin' => 'required|digits:6']);
        Auth::user()->update(['security_pin' => bcrypt($request->pin)]);
        return back()->with('success', 'Security PIN updated.');
    }
}
