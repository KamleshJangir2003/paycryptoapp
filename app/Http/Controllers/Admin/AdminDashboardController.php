<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Deposit, Withdrawal, Commission};

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::where('role', 'user')->count(),
            'pending_deposits'  => Deposit::where('status', 'pending')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_deposited'   => Deposit::where('status', 'approved')->sum('amount'),
            'total_withdrawn'   => Withdrawal::where('status', 'completed')->sum('amount'),
            'total_commission'  => Commission::sum('commission_amount'),
        ];
        $recentDeposits    = Deposit::with('user')->latest()->take(5)->get();
        $recentWithdrawals = Withdrawal::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentDeposits', 'recentWithdrawals'));
    }
}
