<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Deposit, Withdrawal, Commission, PaymentSetting};

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usdtRate = (float) (PaymentSetting::get()->usdt_rate ?: 85.00);

        $stats = [
            'total_users'          => User::count(),
            'pending_deposits'     => Deposit::where('status', 'pending')->count(),
            'pending_withdrawals'  => Withdrawal::where('status', 'pending')->count(),
            'total_deposited'      => Deposit::where('status', 'approved')->sum('amount'),
            'total_withdrawn'      => Withdrawal::where('status', 'completed')->sum('amount'),
            'total_commission'     => Commission::sum('commission_amount'),
            'total_usdt_deposited' => Deposit::where('status', 'approved')->where('payment_type', 'usdt')->sum('usdt_amount'),
            'total_upi_deposited'  => Deposit::where('status', 'approved')->where('payment_type', 'upi')->sum('amount'),
        ];

        $recentDeposits    = Deposit::with('user')->latest()->take(6)->get();
        $recentWithdrawals = Withdrawal::with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentDeposits', 'recentWithdrawals', 'usdtRate'));
    }
}
