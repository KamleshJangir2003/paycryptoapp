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
        return view('deposit.create', compact('payment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'     => 'required|numeric|min:100',
            'utr_number' => 'required|string|max:50',
            'screenshot' => 'required|image|max:2048',
            'upi_id'     => 'nullable|string|max:100',
        ]);

        $path = $request->file('screenshot')->store('deposits', 'public');

        Deposit::create([
            'user_id'    => Auth::id(),
            'amount'     => $request->amount,
            'utr_number' => $request->utr_number,
            'screenshot' => $path,
            'upi_id'     => $request->upi_id,
            'status'     => 'pending',
        ]);

        return redirect()->route('deposit.index')->with('success', 'Deposit request submitted. Awaiting admin approval.');
    }
}
