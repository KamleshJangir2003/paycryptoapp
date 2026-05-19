<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('wallet');
        $recentTransactions = $user->transactions()
            ->where('wallet', '!=', 'pending')
            ->latest()->take(5)->get();
        $referralCount = $user->referrals()->count();
        $todayVolume = $user->deposits()->where('status', 'approved')->whereDate('created_at', today())->sum('amount')
                     + $user->withdrawals()->where('status', 'completed')->whereDate('created_at', today())->sum('amount');
        $performanceTarget = 10000; // ₹10,000 daily target
        return view('dashboard', compact('user', 'recentTransactions', 'referralCount', 'todayVolume', 'performanceTarget'));
    }
}
