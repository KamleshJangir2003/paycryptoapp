<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Auth::user()->deposits()->latest()->paginate(10);
        return view('deposit.index', compact('deposits'));
    }

    public function create()
    {
        $payment = PaymentSetting::get();
        $usdtRate = (float) ($payment->usdt_rate ?: 85.00);
        return view('deposit.create', compact('payment', 'usdtRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:1',
            'payment_type' => 'required|in:upi,usdt',
            'utr_number'   => 'required|string|max:100',
            'screenshot'   => 'required|image|max:2048',
            'upi_id'       => 'nullable|string|max:100',
        ]);

        $payment  = PaymentSetting::get();
        $usdtRate = (float) ($payment->usdt_rate ?: 85.00);

        // If USDT deposit: amount field = USDT amount, convert to INR
        if ($request->payment_type === 'usdt') {
            $usdtAmount = $request->amount;
            $inrAmount  = round($usdtAmount * $usdtRate, 2);
        } else {
            $inrAmount  = $request->amount;
            $usdtAmount = round($inrAmount / $usdtRate, 6);
        }

        $path = $request->file('screenshot')->store('deposits', 'public');

        Deposit::create([
            'user_id'           => Auth::id(),
            'amount'            => $inrAmount,
            'usdt_amount'       => $usdtAmount,
            'usdt_rate_at_time' => $usdtRate,
            'payment_type'      => $request->payment_type,
            'utr_number'        => $request->utr_number,
            'screenshot'        => $path,
            'upi_id'            => $request->upi_id,
            'status'            => 'pending',
        ]);

        return redirect()->route('deposit.index')->with('success', 'Deposit request submitted. Awaiting admin approval.');
    }
}
