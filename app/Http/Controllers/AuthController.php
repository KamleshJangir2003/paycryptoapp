<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $refCode = $request->query('ref');
        return view('auth.register', compact('refCode'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10|unique:users,mobile']);
        $otp = rand(100000, 999999);
        session(['reg_mobile' => $request->mobile, 'reg_otp' => $otp, 'otp_expires' => now()->addMinutes(5)]);
        if ($request->ref_code) session(['reg_ref' => $request->ref_code]);
        return redirect()->route('register.verify')->with('dev_otp', $otp);
    }

    public function showVerify() { return view('auth.verify'); }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        if (
            session('reg_otp') != $request->otp ||
            now()->gt(session('otp_expires'))
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }
        session(['otp_verified' => true]);
        return redirect()->route('register.complete');
    }

    public function showComplete() {
        if (!session('otp_verified')) return redirect()->route('register');
        return view('auth.complete');
    }

    public function completeRegister(Request $request)
    {
        if (!session('otp_verified')) return redirect()->route('register');

        $request->validate([
            'name'     => 'required|string|max:100',
            'password' => 'required|min:6|confirmed',
            'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        $referrer = null;
        $refCode = $request->referral_code ?: session('reg_ref');
        if ($refCode) {
            $referrer = User::where('referral_code', $refCode)->first();
        }

        $user = User::create([
            'name'        => $request->name,
            'mobile'      => session('reg_mobile'),
            'password'    => Hash::make($request->password),
            'referred_by' => $referrer?->id,
            'is_verified' => true,
        ]);

        // Referrer ko 1000 Rs reward
        if ($referrer) {
            $referrer->wallet->increment('earnings_balance', 1000);
            $referrer->commissions()->create([
                'from_user_id'       => $user->id,
                'type'               => 'referral',
                'transaction_amount' => 1000,
                'commission_rate'    => 0,
                'commission_amount'  => 1000,
                'reference_id'       => $user->referral_code,
                'status'             => 'credited',
            ]);
        }

        session()->forget(['reg_mobile', 'reg_otp', 'otp_expires', 'otp_verified', 'reg_ref']);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10', 'password' => 'required']);
        if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password], $request->remember)) {
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors(['mobile' => 'Account is disabled']);
            }
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->withErrors(['mobile' => 'Use admin login panel']);
            }
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['mobile' => 'Invalid mobile or password']);
    }

    public function showAdminLogin() { return view('auth.admin-login'); }

    public function adminLogin(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid admin credentials']);
    }

    public function adminLogout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
