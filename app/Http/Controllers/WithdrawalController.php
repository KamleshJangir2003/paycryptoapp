<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\WithdrawalTransaction;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Auth::user()->withdrawals()->with('partialTransactions')->latest()->paginate(10);
        $pool = Withdrawal::with('partialTransactions')
            ->whereIn('status', ['pending', 'processing'])
            ->where('in_pool', true)
            ->latest()->get();
        return view('withdrawal.index', compact('withdrawals', 'pool'));
    }

    // AJAX: live pool refresh
    public function livePool()
    {
        $pool = Withdrawal::with('partialTransactions')
            ->whereIn('status', ['pending', 'processing'])
            ->where('in_pool', true)
            ->latest()->get();

        $html = '';
        if ($pool->isEmpty()) {
            $html = '<div class="text-center py-4"><div style="font-size:2rem;">✅</div><div class="text-muted mt-2" style="font-size:.9rem;">Pool is empty</div></div>';
        } else {
            foreach ($pool as $p) {
                $html .= view('withdrawal._pool_item', compact('p'))->render();
            }
        }

        // hash so frontend only re-renders on actual change
        $hash = md5($pool->map(fn($p) => $p->id.':'.$p->status.':'.$p->partialTransactions->count().':'.$p->partialTransactions->sum('amount'))->join(','));

        return response()->json(compact('html', 'hash'));
    }

    public function create()
    {
        $user     = Auth::user()->load('wallet');
        $usdtRate = (float) (PaymentSetting::get()->usdt_rate ?: 85.00);
        return view('withdrawal.create', compact('user', 'usdtRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'        => 'required|numeric|min:100',
            'method'        => 'required|in:upi,bank,qr',
            'upi_id'        => 'required_if:method,upi|nullable|string',
            'bank_account'  => 'required_if:method,bank|nullable|string',
            'bank_ifsc'     => 'required_if:method,bank|nullable|string',
            'bank_name'     => 'required_if:method,bank|nullable|string',
            'qr_screenshot' => 'required_if:method,qr|nullable|image|max:2048',
        ]);

        $user = Auth::user()->load('wallet');
        $wallet = $user->wallet;

        if ($wallet->main_balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance']);
        }

        $screenshotPath = null;
        if ($request->method === 'qr' && $request->hasFile('qr_screenshot')) {
            $screenshotPath = $request->file('qr_screenshot')->store('withdrawals/qr', 'public');
        }

        DB::transaction(function () use ($request, $user, $wallet, $screenshotPath) {
            $wallet->decrement('main_balance', $request->amount);
            $wallet->increment('pending_balance', $request->amount);

            $withdrawal = Withdrawal::create([
                'user_id'        => $user->id,
                'amount'         => $request->amount,
                'method'         => $request->method,
                'upi_id'         => $request->upi_id,
                'bank_account'   => $request->bank_account,
                'bank_ifsc'      => $request->bank_ifsc,
                'bank_name'      => $request->bank_name,
                'qr_screenshot'  => $screenshotPath,
                'status'         => 'pending',
                'in_pool'        => true,
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

    // User partial transaction confirm karta hai
    public function confirmPartial(WithdrawalTransaction $partialTransaction)
    {
        $withdrawal = $partialTransaction->withdrawal;

        if ($withdrawal->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($partialTransaction->status !== 'pending') {
            return back()->with('error', 'Already confirmed.');
        }

        DB::transaction(function () use ($partialTransaction, $withdrawal) {
            $partialTransaction->update([
                'status'       => 'confirmed',
                'confirmed_at' => now(),
            ]);

            $wallet = $withdrawal->user->wallet;
            $wallet->decrement('pending_balance', $partialTransaction->amount);
        });

        return back()->with('success', 'Payment confirmed!');
    }

    public function receipt(Withdrawal $withdrawal)
    {
        if ($withdrawal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $totalWithdrawals = Withdrawal::where('user_id', Auth::id())
            ->where('status', 'completed')->count();
        $totalAmount = Withdrawal::where('user_id', Auth::id())
            ->where('status', 'completed')->sum('amount');

        return view('withdrawal.receipt', compact('withdrawal', 'totalWithdrawals', 'totalAmount'));
    }
}
