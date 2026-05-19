<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class FinanceReportController extends Controller
{
    public function finance(Request $request)
    {
        $user = Auth::user()->load('wallet');

        $filter = $request->get('filter', 'all');

        $txQuery = $user->transactions()->where('wallet', '!=', 'pending');

        if ($filter === 'deposit')    $txQuery->where('type', 'deposit');
        if ($filter === 'withdrawal') $txQuery->where('type', 'withdrawal');
        if ($filter === 'commission') $txQuery->whereIn('type', ['commission', 'referral', 'bonus']);
        if ($filter === 'this_month') $txQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        if ($filter === 'today')      $txQuery->whereDate('created_at', today());

        $transactions = $txQuery->latest()->paginate(15)->withQueryString();

        // Summary stats
        $totalDeposited  = $user->deposits()->where('status', 'approved')->sum('amount');
        $totalWithdrawn  = $user->withdrawals()->where('status', 'completed')->sum('amount');
        $totalCommission = $user->commissions()->sum('commission_amount');
        $thisMonthDep    = $user->deposits()->where('status', 'approved')->whereMonth('created_at', now()->month)->sum('amount');
        $thisMonthWith   = $user->withdrawals()->where('status', 'completed')->whereMonth('created_at', now()->month)->sum('amount');
        $todayDep        = $user->deposits()->where('status', 'approved')->whereDate('created_at', today())->sum('amount');

        return view('reports.finance', compact(
            'user', 'transactions', 'filter',
            'totalDeposited', 'totalWithdrawn', 'totalCommission',
            'thisMonthDep', 'thisMonthWith', 'todayDep'
        ));
    }

    public function adjustment()
    {
        $user = Auth::user()->load('wallet');

        $adjustments = $user->transactions()
            ->whereIn('type', ['security_hold', 'security_release', 'bonus'])
            ->latest()
            ->paginate(15);

        $securityHolds   = $user->securityHolds()->where('status', 'held')->sum('amount');
        $totalBonuses    = $user->transactions()->where('type', 'bonus')->where('direction', 'credit')->sum('amount');
        $totalHoldAmount = $user->securityHolds()->sum('amount');

        return view('reports.adjustment', compact(
            'user', 'adjustments', 'securityHolds', 'totalBonuses', 'totalHoldAmount'
        ));
    }
}
