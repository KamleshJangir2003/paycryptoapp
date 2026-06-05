<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPaymentSettingController extends Controller
{
    public function index()
    {
        $setting = PaymentSetting::get();
        return view('admin.payment-settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'upi_id'         => 'nullable|string|max:100',
            'upi_name'       => 'nullable|string|max:100',
            'qr_image'       => 'nullable|image|max:2048',
            'wallet_address' => 'nullable|string|max:200',
            'wallet_name'    => 'nullable|string|max:100',
            'wallet_qr'      => 'nullable|image|max:2048',
            'deposit_note'   => 'nullable|string|max:500',
            'usdt_rate'      => 'nullable|numeric|min:1',
            'whatsapp_link'  => 'nullable|url|max:200',
            'telegram_link'  => 'nullable|url|max:200',
        ]);

        $setting = PaymentSetting::get();
        $data = $request->only('upi_id', 'upi_name', 'wallet_address', 'wallet_name', 'deposit_note', 'usdt_rate', 'whatsapp_link', 'telegram_link');

        $data['upi_active']    = $request->has('upi_active');
        $data['wallet_active'] = $request->has('wallet_active');

        // Upload UPI QR
        if ($request->hasFile('qr_image')) {
            if ($setting->qr_image) Storage::disk('public')->delete($setting->qr_image);
            $data['qr_image'] = $request->file('qr_image')->store('payment', 'public');
        }

        // Upload Wallet QR
        if ($request->hasFile('wallet_qr')) {
            if ($setting->wallet_qr) Storage::disk('public')->delete($setting->wallet_qr);
            $data['wallet_qr'] = $request->file('wallet_qr')->store('payment', 'public');
        }

        $setting->update($data);

        return back()->with('success', 'Payment settings updated successfully.');
    }
}
