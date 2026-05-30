<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('wallet');
        $recentTransactions = $user->transactions()
            ->where('wallet', '!=', 'pending')
            ->with('deposit')
            ->latest()->take(5)->get();
        $referralCount = $user->referrals()->count();
        $todayVolume = $user->deposits()->where('status', 'approved')->whereDate('created_at', today())->sum('amount')
                     + $user->withdrawals()->where('status', 'completed')->whereDate('created_at', today())->sum('amount');
        $performanceTarget = 10000;
        $usdtRate = (float) (PaymentSetting::get()->usdt_rate ?: 85.00);
        return view('dashboard', compact('user', 'recentTransactions', 'referralCount', 'todayVolume', 'performanceTarget', 'usdtRate'));
    }
}
