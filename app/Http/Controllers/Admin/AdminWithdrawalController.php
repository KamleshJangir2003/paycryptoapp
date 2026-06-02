<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Withdrawal, Commission, Transaction, WithdrawalTransaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(20);
        $pool = Withdrawal::with('user')
            ->whereIn('status', ['pending', 'processing'])
            ->where('in_pool', true)
            ->latest()->get();
        return view('admin.withdrawals.index', compact('withdrawals', 'pool'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') return back()->with('error', 'Already processed');

        $withdrawal->update(['status' => 'processing']);

        return back()->with('success', 'Withdrawal marked as Processing.');
    }

    public function complete(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'processing') return back()->with('error', 'Approve first before completing');

        $request->validate([
            'utr_number' => 'nullable|string|max:100',
            'proof_screenshot' => 'nullable|image|max:5120',
        ]);

        $proofPath = $withdrawal->proof_screenshot;
        if ($request->hasFile('proof_screenshot')) {
            if ($withdrawal->proof_screenshot) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($withdrawal->proof_screenshot);
            }
            $proofPath = $request->file('proof_screenshot')->store('withdrawals/proofs', 'public');
        }

        DB::transaction(function () use ($request, $withdrawal, $proofPath) {
            $withdrawal->update([
                'status'       => 'completed',
                'in_pool'      => false,
                'processed_at' => now(),
                'utr_number'   => $request->utr_number,
                'proof_screenshot' => $proofPath,
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

            $this->creditWithdrawalCommission($withdrawal);
        });

        return back()->with('success', 'Withdrawal completed.');
    }

    // Admin ek partial payment upload karta hai (UTR + screenshot)
    public function uploadPartial(Request $request, Withdrawal $withdrawal)
    {
        if (!in_array($withdrawal->status, ['pending', 'processing'])) {
            return back()->with('error', 'Withdrawal already finalized.');
        }

        $request->validate([
            'amount'           => 'required|numeric|min:1',
            'utr_number'       => 'nullable|string|max:100',
            'proof_screenshot' => 'nullable|image|max:5120',
            'note'             => 'nullable|string|max:255',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_screenshot')) {
            $proofPath = $request->file('proof_screenshot')->store('withdrawals/partials', 'public');
        }

        WithdrawalTransaction::create([
            'withdrawal_id'    => $withdrawal->id,
            'amount'           => $request->amount,
            'utr_number'       => $request->utr_number,
            'proof_screenshot' => $proofPath,
            'note'             => $request->note,
            'status'           => 'pending',
        ]);

        // Withdrawal ko processing mark karo agar pending tha
        if ($withdrawal->status === 'pending') {
            $withdrawal->update(['status' => 'processing']);
        }

        return back()->with('success', 'Partial payment uploaded. User se confirmation ka wait karo.');
    }

    // Admin final summary upload karta hai aur withdrawal complete karta hai
    public function finalize(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Withdrawal is not in processing state.');
        }

        $unconfirmed = $withdrawal->partialTransactions()->where('status', 'pending')->count();
        if ($unconfirmed > 0) {
            return back()->with('error', "$unconfirmed partial payment(s) user ne confirm nahi kiye. Pehle user confirm kare.");
        }

        $request->validate([
            'utr_number'       => 'nullable|string|max:100',
            'proof_screenshot' => 'nullable|image|max:5120',
        ]);

        $proofPath = $withdrawal->proof_screenshot;
        if ($request->hasFile('proof_screenshot')) {
            if ($proofPath) Storage::disk('public')->delete($proofPath);
            $proofPath = $request->file('proof_screenshot')->store('withdrawals/proofs', 'public');
        }

        DB::transaction(function () use ($request, $withdrawal, $proofPath) {
            $withdrawal->update([
                'status'           => 'completed',
                'in_pool'          => false,
                'processed_at'     => now(),
                'utr_number'       => $request->utr_number,
                'proof_screenshot' => $proofPath,
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
                'description'  => 'Withdrawal completed (partial payments)',
                'status'       => 'completed',
            ]);

            $this->creditWithdrawalCommission($withdrawal);
        });

        return back()->with('success', 'Withdrawal fully completed!');
    }

    public function summary(Withdrawal $withdrawal)
    {
        $withdrawal->load('user');
        $totalWithdrawals = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')->count();
        $totalAmount = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')->sum('amount');
        return view('admin.withdrawals.summary', compact('withdrawal', 'totalWithdrawals', 'totalAmount'));
    }

    public function receipt(Withdrawal $withdrawal)
    {
        $withdrawal->load('user');
        $totalWithdrawals = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')->count();
        $totalAmount = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('status', 'completed')->sum('amount');

        return view('admin.withdrawals.receipt', compact('withdrawal', 'totalWithdrawals', 'totalAmount'));
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
