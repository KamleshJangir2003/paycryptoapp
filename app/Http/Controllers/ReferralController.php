<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $referralLink = url('/register?ref=' . $user->referral_code);

        $referrals = $user->referrals()
            ->with('wallet')
            ->withCount(['deposits as total_deposits' => function($q) {
                $q->where('status', 'approved');
            }])
            ->latest()
            ->get();

        $totalEarned = $user->commissions()
            ->whereIn('type', ['deposit', 'withdrawal', 'referral'])
            ->sum('commission_amount');

        $thisMonthEarned = $user->commissions()
            ->whereMonth('created_at', now()->month)
            ->sum('commission_amount');

        $commissions = $user->commissions()->with('fromUser')->latest()->take(20)->get();

        return view('referral.index', compact(
            'user', 'referralLink', 'referrals',
            'totalEarned', 'thisMonthEarned', 'commissions'
        ));
    }
}
