<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $refCode = $request->query('ref');
        return view('auth.register', compact('refCode'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:users,email']);
        $otp = rand(100000, 999999);
        session(['reg_email' => $request->email, 'reg_otp' => $otp, 'otp_expires' => now()->addMinutes(5)]);
        if ($request->ref_code) session(['reg_ref' => $request->ref_code]);
        Mail::to($request->email)->send(new OtpMail($otp));
        return redirect()->route('register.verify');
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
            'mobile'   => 'required|digits:10|unique:users,mobile',
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
            'mobile'      => $request->mobile,
            'email'       => session('reg_email'),
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

        session()->forget(['reg_email', 'reg_otp', 'otp_expires', 'otp_verified', 'reg_ref']);
        Auth::login($user);
        return redirect()->route('dashboard')->with('show_app_download', true);
    }

    public function showLogin() { return view('auth.login'); }

    public function showForgotPassword() { return view('auth.forgot-password'); }

    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $otp = rand(100000, 999999);
        session(['reset_email' => $request->email, 'reset_otp' => $otp, 'reset_otp_expires' => now()->addMinutes(10)]);
        Mail::to($request->email)->send(new OtpMail($otp));
        return redirect()->route('password.reset.form');
    }

    public function showResetPassword()
    {
        if (!session('reset_email')) return redirect()->route('password.forgot');
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp'      => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if (session('reset_otp') != $request->otp || now()->gt(session('reset_otp_expires'))) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        User::where('email', session('reset_email'))->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget(['reset_email', 'reset_otp', 'reset_otp_expires']);
        return redirect()->route('login')->with('success', 'Password reset successfully! Please login.');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Account is disabled']);
            }
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function showAdminLogin() { return view('auth.admin-login'); }

    public function showAdminForgotPassword() { return view('auth.admin-forgot-password'); }

    public function sendAdminResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);
        $otp = rand(100000, 999999);
        session(['admin_reset_email' => $request->email, 'admin_reset_otp' => $otp, 'admin_reset_otp_expires' => now()->addMinutes(10)]);
        Mail::to($request->email)->send(new OtpMail($otp));
        return redirect()->route('admin.password.reset.form');
    }

    public function showAdminResetPassword()
    {
        if (!session('admin_reset_email')) return redirect()->route('admin.password.forgot');
        return view('auth.admin-reset-password');
    }

    public function resetAdminPassword(Request $request)
    {
        $request->validate([
            'otp'      => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if (session('admin_reset_otp') != $request->otp || now()->gt(session('admin_reset_otp_expires'))) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        \App\Models\Admin::where('email', session('admin_reset_email'))->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget(['admin_reset_email', 'admin_reset_otp', 'admin_reset_otp_expires']);
        return redirect()->route('admin.login')->with('success', 'Password reset successfully! Please login.');
    }

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
