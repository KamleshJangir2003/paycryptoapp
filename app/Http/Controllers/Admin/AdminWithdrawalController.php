<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Withdrawal, Commission, Transaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(20);
        $pool = Withdrawal::with('user')->where('status', 'pending')->where('in_pool', true)->latest()->get();
        return view('admin.withdrawals.index', compact('withdrawals', 'pool'));
    }

    public function complete(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') return back()->with('error', 'Already processed');

        DB::transaction(function () use ($request, $withdrawal) {
            $withdrawal->update([
                'status'       => 'completed',
                'in_pool'      => false,
                'processed_at' => now(),
            ]);

            $wallet = $withdrawal->user->wallet;
            $wallet->decrement('pending_balance', $withdrawal->amount);

            Transaction::create([
                'user_id'      => $withdrawal->user_id,
                'type'         => 'withdrawal',
                'wallet'       => 'main',
                'direction'    => 'debit',
                'amount'       => $withdrawal->amount,
                'balance_after'=> $wallet->main_balance,
                'reference_id' => $withdrawal->id,
                'description'  => 'Withdrawal completed',
                'status'       => 'completed',
            ]);

            // Commission: 0.5% to referrer on withdrawal
            $this->creditWithdrawalCommission($withdrawal);
        });

        return back()->with('success', 'Withdrawal completed.');
    }

    public function fail(Request $request, Withdrawal $withdrawal)
    {
        $request->validate(['admin_note' => 'required|string']);
        DB::transaction(function () use ($request, $withdrawal) {
            $withdrawal->update([
                'status'       => 'failed',
                'in_pool'      => false,
                'processed_at' => now(),
                'admin_note'   => $request->admin_note,
            ]);
            // Refund to main wallet
            $wallet = $withdrawal->user->wallet;
            $wallet->decrement('pending_balance', $withdrawal->amount);
            $wallet->increment('main_balance', $withdrawal->amount);

            Transaction::create([
                'user_id'      => $withdrawal->user_id,
                'type'         => 'withdrawal',
                'wallet'       => 'main',
                'direction'    => 'credit',
                'amount'       => $withdrawal->amount,
                'balance_after'=> $wallet->main_balance,
                'reference_id' => $withdrawal->id,
                'description'  => 'Withdrawal failed - refunded',
                'status'       => 'failed',
            ]);
        });
        return back()->with('success', 'Withdrawal marked failed and amount refunded.');
    }

    private function creditWithdrawalCommission(Withdrawal $withdrawal)
    {
        $referrer = $withdrawal->user->referredBy;
        if (!$referrer) return;

        $rate = 0.5;
        $commissionAmount = round($withdrawal->amount * $rate / 100, 2);

        $referrer->wallet->increment('earnings_balance', $commissionAmount);

        Commission::create([
            'user_id'            => $referrer->id,
            'from_user_id'       => $withdrawal->user_id,
            'type'               => 'withdrawal',
            'transaction_amount' => $withdrawal->amount,
            'commission_rate'    => $rate,
            'commission_amount'  => $commissionAmount,
            'reference_id'       => $withdrawal->id,
            'status'             => 'credited',
        ]);
    }
}
