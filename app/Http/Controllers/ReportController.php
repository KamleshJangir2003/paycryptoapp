<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('wallet');
        $totalDeposited  = $user->deposits()->where('status', 'approved')->sum('amount');
        $totalWithdrawn  = $user->withdrawals()->where('status', 'completed')->sum('amount');
        $totalCommission = $user->commissions()->sum('commission_amount');
        $referralCount   = $user->referrals()->count();
        $transactions    = $user->transactions()->latest()->paginate(15);

        return view('report.index', compact(
            'user', 'totalDeposited', 'totalWithdrawn',
            'totalCommission', 'referralCount', 'transactions'
        ));
    }
}
