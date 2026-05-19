<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Auth::user()->withdrawals()->latest()->paginate(10);
        $pool = Withdrawal::where('status', 'pending')->where('in_pool', true)->latest()->get();
        return view('withdrawal.index', compact('withdrawals', 'pool'));
    }

    public function create()
    {
        $user = Auth::user()->load('wallet');
        return view('withdrawal.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required|in:upi,bank',
            'upi_id' => 'required_if:method,upi|nullable|string',
            'bank_account' => 'required_if:method,bank|nullable|string',
            'bank_ifsc'    => 'required_if:method,bank|nullable|string',
            'bank_name'    => 'required_if:method,bank|nullable|string',
        ]);

        $user = Auth::user()->load('wallet');
        $wallet = $user->wallet;

        if ($wallet->main_balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance']);
        }

        DB::transaction(function () use ($request, $user, $wallet) {
            $wallet->decrement('main_balance', $request->amount);
            $wallet->increment('pending_balance', $request->amount);

            $withdrawal = Withdrawal::create([
                'user_id'      => $user->id,
                'amount'       => $request->amount,
                'method'       => $request->method,
                'upi_id'       => $request->upi_id,
                'bank_account' => $request->bank_account,
                'bank_ifsc'    => $request->bank_ifsc,
                'bank_name'    => $request->bank_name,
                'status'       => 'pending',
                'in_pool'      => true,
            ]);

            Transaction::create([
                'user_id'      => $user->id,
                'type'         => 'withdrawal',
                'wallet'       => 'pending',
                'direction'    => 'debit',
                'amount'       => $request->amount,
                'balance_after'=> $wallet->main_balance,
                'reference_id' => $withdrawal->id,
                'description'  => 'Withdrawal request submitted',
                'status'       => 'pending',
            ]);
        });

        return redirect()->route('withdrawal.index')->with('success', 'Withdrawal request added to pool.');
    }
}
