<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Transaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWalletController extends Controller
{
    public function adjust(Request $request, User $user)
    {
        $request->validate([
            'wallet'    => 'required|in:main,earnings,pending',
            'direction' => 'required|in:credit,debit',
            'amount'    => 'required|numeric|min:1',
            'reason'    => 'required|string|max:200',
        ]);

        DB::transaction(function () use ($request, $user) {
            $wallet = $user->wallet;
            $field  = $request->wallet . '_balance';
            $amount = $request->amount;

            if ($request->direction === 'credit') {
                $wallet->increment($field, $amount);
            } else {
                if ($wallet->$field < $amount) {
                    throw new \Exception('Insufficient balance in ' . $request->wallet . ' wallet');
                }
                $wallet->decrement($field, $amount);
            }

            Transaction::create([
                'user_id'      => $user->id,
                'type'         => 'bonus',
                'wallet'       => $request->wallet,
                'direction'    => $request->direction,
                'amount'       => $amount,
                'balance_after'=> $wallet->fresh()->$field,
                'description'  => 'Admin adjustment: ' . $request->reason,
                'status'       => 'completed',
            ]);
        });

        return back()->with('success', 'Wallet adjusted successfully.');
    }
}
