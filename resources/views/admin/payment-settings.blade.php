@extends('layouts.admin')
@section('title', 'Payment Settings')
@section('content')

<form method="POST" action="{{ route('admin.payment.settings.update') }}" enctype="multipart/form-data">
@csrf

<div class="row g-4">

{{-- UPI Section --}}
<div class="col-12 col-lg-6">
<div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📱 UPI Payment</span>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="upi_active" id="upiActive" {{ $setting->upi_active ? 'checked' : '' }}>
            <label class="form-check-label" for="upiActive" style="color:#c0c0e0;">Active</label>
        </div>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">UPI ID</label>
            <input type="text" name="upi_id" class="form-control" placeholder="e.g. fastpayz@upi" value="{{ $setting->upi_id }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Display Name</label>
            <input type="text" name="upi_name" class="form-control" placeholder="e.g. FastPayz Official" value="{{ $setting->upi_name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">UPI QR Code Image</label>
            <input type="file" name="qr_image" class="form-control" accept="image/*" onchange="previewImg(this,'upiPreview')">
            <div style="color:#5a5a80; font-size:.8rem; margin-top:4px;">Upload QR code image (PNG/JPG, max 2MB)</div>
        </div>

        {{-- Current QR Preview --}}
        <div class="text-center mt-3">
            @if($setting->qr_image)
                <div style="color:#8888aa; font-size:.8rem; margin-bottom:8px;">Current QR Code</div>
                <img id="upiPreview" src="{{ asset('storage/'.$setting->qr_image) }}"
                    style="width:180px; height:180px; object-fit:contain; background:#0a0a14; border:2px solid #2a2a50; border-radius:12px; padding:8px;">
            @else
                <div id="upiPreviewWrap" style="width:180px; height:180px; background:#0a0a14; border:2px dashed #3a3a60; border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                    <img id="upiPreview" src="" style="display:none; width:100%; height:100%; object-fit:contain; border-radius:10px;">
                    <span id="upiPlaceholder" style="color:#5a5a80; font-size:.85rem; text-align:center;">
                        <i class="bi bi-qr-code" style="font-size:2rem; display:block; margin-bottom:6px;"></i>
                        No QR uploaded
                    </span>
                </div>
            @endif
        </div>

    </div>
</div>
</div>

{{-- Wallet Section --}}
<div class="col-12 col-lg-6">
<div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>💎 Crypto / Wallet</span>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="wallet_active" id="walletActive" {{ $setting->wallet_active ? 'checked' : '' }}>
            <label class="form-check-label" for="walletActive" style="color:#c0c0e0;">Active</label>
        </div>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Wallet Address</label>
            <input type="text" name="wallet_address" class="form-control" placeholder="e.g. TRC20 / BEP20 address" value="{{ $setting->wallet_address }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Wallet Name / Network</label>
            <input type="text" name="wallet_name" class="form-control" placeholder="e.g. USDT TRC20" value="{{ $setting->wallet_name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Wallet QR Code Image</label>
            <input type="file" name="wallet_qr" class="form-control" accept="image/*" onchange="previewImg(this,'walletPreview')">
            <div style="color:#5a5a80; font-size:.8rem; margin-top:4px;">Upload wallet QR code (PNG/JPG, max 2MB)</div>
        </div>

        {{-- Current Wallet QR Preview --}}
        <div class="text-center mt-3">
            @if($setting->wallet_qr)
                <div style="color:#8888aa; font-size:.8rem; margin-bottom:8px;">Current Wallet QR</div>
                <img id="walletPreview" src="{{ asset('storage/'.$setting->wallet_qr) }}"
                    style="width:180px; height:180px; object-fit:contain; background:#0a0a14; border:2px solid #2a2a50; border-radius:12px; padding:8px;">
            @else
                <div id="walletPreviewWrap" style="width:180px; height:180px; background:#0a0a14; border:2px dashed #3a3a60; border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                    <img id="walletPreview" src="" style="display:none; width:100%; height:100%; object-fit:contain; border-radius:10px;">
                    <span id="walletPlaceholder" style="color:#5a5a80; font-size:.85rem; text-align:center;">
                        <i class="bi bi-wallet2" style="font-size:2rem; display:block; margin-bottom:6px;"></i>
                        No QR uploaded
                    </span>
                </div>
            @endif
        </div>

    </div>
</div>
</div>

{{-- Social / Community Links --}}
<div class="col-12">
<div class="card">
    <div class="card-header">📣 Community Links (shown to users)</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label"><i class="bi bi-whatsapp me-1" style="color:#25D366;"></i>WhatsApp Channel Link</label>
                <input type="url" name="whatsapp_link" class="form-control" placeholder="https://whatsapp.com/channel/..." value="{{ $setting->whatsapp_link }}">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label"><i class="bi bi-telegram me-1" style="color:#0088cc;"></i>Telegram Channel Link</label>
                <input type="url" name="telegram_link" class="form-control" placeholder="https://t.me/yourchannel" value="{{ $setting->telegram_link }}">
            </div>
        </div>
    </div>
</div>
</div>

{{-- Deposit Note --}}
<div class="col-12">
<div class="card">
    <div class="card-header">📝 Deposit Instructions (shown to users)</div>
    <div class="card-body">
        <textarea name="deposit_note" class="form-control" rows="3"
            placeholder="e.g. After payment, enter UTR number and upload screenshot. Deposits are processed within 30 minutes.">{{ $setting->deposit_note }}</textarea>
    </div>
</div>
</div>

{{-- USDT Rate --}}
<div class="col-12">
<div class="card">
    <div class="card-header">💱 USDT Rate (INR per 1 USDT)</div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background:#1a1a2e; border-color:#3a3a60; color:#f0a500;">₹</span>
                    <input type="number" name="usdt_rate" class="form-control" step="0.01" min="1"
                        value="{{ $setting->usdt_rate ?? 85.00 }}" placeholder="e.g. 85.50">
                    <span class="input-group-text" style="background:#1a1a2e; border-color:#3a3a60; color:#26a17b;">/ USDT</span>
                </div>
                <div style="color:#5a5a80; font-size:.8rem; margin-top:4px;">This rate will be shown to users on dashboard & deposit page.</div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div style="background:#0a0a14; border:1px solid #2a2a50; border-radius:10px; padding:14px 18px;">
                    <div style="color:#8888aa; font-size:.8rem;">Current Rate</div>
                    <div style="font-size:1.4rem; font-weight:700; color:#26a17b;">1 USDT = <span style="color:#f0a500;">₹{{ number_format($setting->usdt_rate ?? 85, 2) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>

<div class="mt-4 text-end">
    <button type="submit" class="btn btn-primary px-5 py-2">
        <i class="bi bi-save-fill me-2"></i>Save Payment Settings
    </button>
</div>

</form>

@endsection
@section('scripts')
<script>
function previewImg(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.style.display = 'block';
        // hide placeholder if exists
        const ph = document.getElementById(previewId.replace('Preview','Placeholder'));
        if (ph) ph.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
