<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Deposit, Commission, Transaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('user')->latest()->paginate(20);
        return view('admin.deposits.index', compact('deposits'));
    }

    public function approve(Request $request, Deposit $deposit)
    {
        if ($deposit->status !== 'pending') return back()->with('error', 'Already processed');

        DB::transaction(function () use ($deposit) {
            $deposit->update([
                'status'      => 'approved',
                'verified_by' => Auth::guard('admin')->id(),
                'verified_at' => now(),
            ]);

            $wallet = $deposit->user->wallet;
            $wallet->increment('main_balance', $deposit->amount);

            Transaction::create([
                'user_id'      => $deposit->user_id,
                'type'         => 'deposit',
                'wallet'       => 'main',
                'direction'    => 'credit',
                'amount'       => $deposit->amount,
                'balance_after'=> $wallet->main_balance,
                'reference_id' => $deposit->id,
                'description'  => 'Deposit approved',
                'status'       => 'completed',
            ]);

            // Commission: 1% to referrer
            $this->creditReferralCommission($deposit);
        });

        return back()->with('success', 'Deposit approved and wallet credited.');
    }

    public function reject(Request $request, Deposit $deposit)
    {
        $request->validate(['admin_note' => 'required|string']);
        $deposit->update([
            'status'      => 'rejected',
            'verified_by' => Auth::guard('admin')->id(),
            'verified_at' => now(),
            'admin_note'  => $request->admin_note,
        ]);
        return back()->with('success', 'Deposit rejected.');
    }

    private function creditReferralCommission(Deposit $deposit)
    {
        $referrer = $deposit->user->referredBy;
        if (!$referrer) return;

        $rate = 1.0; // 1%
        $commissionAmount = round($deposit->amount * $rate / 100, 2);

        $referrer->wallet->increment('earnings_balance', $commissionAmount);

        Commission::create([
            'user_id'            => $referrer->id,
            'from_user_id'       => $deposit->user_id,
            'type'               => 'deposit',
            'transaction_amount' => $deposit->amount,
            'commission_rate'    => $rate,
            'commission_amount'  => $commissionAmount,
            'reference_id'       => $deposit->id,
            'status'             => 'credited',
        ]);

        Transaction::create([
            'user_id'      => $referrer->id,
            'type'         => 'commission',
            'wallet'       => 'earnings',
            'direction'    => 'credit',
            'amount'       => $commissionAmount,
            'balance_after'=> $referrer->wallet->earnings_balance,
            'reference_id' => $deposit->id,
            'description'  => 'Referral commission on deposit',
            'status'       => 'completed',
        ]);
    }
}
