<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Deposit, Withdrawal, Commission, Transaction};
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function finance()
    {
        $stats = [
            'total_deposited'    => Deposit::where('status', 'approved')->sum('amount'),
            'total_withdrawn'    => Withdrawal::where('status', 'completed')->sum('amount'),
            'total_commission'   => Commission::sum('commission_amount'),
            'pending_deposits'   => Deposit::where('status', 'pending')->sum('amount'),
            'pending_withdrawals'=> Withdrawal::where('status', 'pending')->sum('amount'),
            'today_deposited'    => Deposit::where('status', 'approved')->whereDate('created_at', today())->sum('amount'),
            'today_withdrawn'    => Withdrawal::where('status', 'completed')->whereDate('created_at', today())->sum('amount'),
            'this_month_dep'     => Deposit::where('status', 'approved')->whereMonth('created_at', now()->month)->sum('amount'),
            'this_month_with'    => Withdrawal::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('amount'),
            'total_users'        => User::where('role', 'user')->count(),
            'active_users'       => User::where('role', 'user')->where('is_active', true)->count(),
        ];

        $recentDeposits    = Deposit::with('user')->latest()->take(10)->get();
        $recentWithdrawals = Withdrawal::with('user')->latest()->take(10)->get();
        $topUsers          = User::where('role', 'user')
            ->withSum(['deposits as total_dep' => fn($q) => $q->where('status', 'approved')], 'amount')
            ->orderByDesc('total_dep')->take(10)->get();

        return view('admin.reports.finance', compact('stats', 'recentDeposits', 'recentWithdrawals', 'topUsers'));
    }

    public function commissions()
    {
        $commissions = Commission::with(['user', 'fromUser'])->latest()->paginate(20);
        $stats = [
            'total'          => Commission::sum('commission_amount'),
            'deposit_comm'   => Commission::where('type', 'deposit')->sum('commission_amount'),
            'withdrawal_comm'=> Commission::where('type', 'withdrawal')->sum('commission_amount'),
            'referral_comm'  => Commission::where('type', 'referral')->sum('commission_amount'),
            'today'          => Commission::whereDate('created_at', today())->sum('commission_amount'),
        ];
        return view('admin.reports.commissions', compact('commissions', 'stats'));
    }
}
