@extends('layouts.app')
@section('title', 'New Deposit')
@section('content')

@php $hasDeposit = auth()->user()->deposits()->where('status','approved')->exists(); @endphp
@unless($hasDeposit)
<div class="alert mb-4" style="background:#0d1a2a; border:1px solid #4db8ff; color:#4db8ff; border-radius:12px; padding:16px 20px;">
    <i class="bi bi-info-circle-fill me-2"></i>
    <strong>One step away from full access!</strong> Complete your first deposit and once it is approved by our team, your entire dashboard will be unlocked — including Withdrawals, Referrals, and Reports.
</div>
@endunless

<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-7">

    {{-- Payment Methods from Admin --}}
    @if($payment->upi_active || $payment->wallet_active)

        <div class="row g-3 mb-4">

            {{-- UPI Section --}}
            @if($payment->upi_active && ($payment->upi_id || $payment->qr_image))
            <div class="{{ $payment->wallet_active ? 'col-12 col-md-6' : 'col-12' }}">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <i class="bi bi-phone-fill me-2" style="color:#f0a500;"></i>Pay via UPI
                    </div>
                    <div class="card-body text-center">

                        {{-- QR Code --}}
                        @if($payment->qr_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$payment->qr_image) }}"
                                style="width:200px; height:200px; object-fit:contain; background:#0d0d1a; border:2px solid #2a2a50; border-radius:14px; padding:10px;">
                        </div>
                        @endif

                        {{-- UPI ID --}}
                        @if($payment->upi_id)
                        <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:10px;">
                            <div style="color:#7777aa; font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">UPI ID</div>
                            <div style="color:#f0a500; font-size:1.15rem; font-weight:800; letter-spacing:.5px;">{{ $payment->upi_id }}</div>
                            @if($payment->upi_name)
                            <div style="color:#8888aa; font-size:.82rem; margin-top:2px;">{{ $payment->upi_name }}</div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary w-100"
                            onclick="navigator.clipboard.writeText('{{ $payment->upi_id }}');this.innerHTML='<i class=\'bi bi-check\'></i> Copied!'">
                            <i class="bi bi-copy me-1"></i>Copy UPI ID
                        </button>
                        @endif

                    </div>
                </div>
            </div>
            @endif

            {{-- Wallet Section --}}
            @if($payment->wallet_active && ($payment->wallet_address || $payment->wallet_qr))
            <div class="{{ $payment->upi_active ? 'col-12 col-md-6' : 'col-12' }}">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <i class="bi bi-wallet2 me-2" style="color:#4db8ff;"></i>
                        Pay via {{ $payment->wallet_name ?? 'Crypto Wallet' }}
                    </div>
                    <div class="card-body text-center">

                        {{-- Wallet QR --}}
                        @if($payment->wallet_qr)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$payment->wallet_qr) }}"
                                style="width:200px; height:200px; object-fit:contain; background:#0d0d1a; border:2px solid #2a2a50; border-radius:14px; padding:10px;">
                        </div>
                        @endif

                        {{-- Wallet Address --}}
                        @if($payment->wallet_address)
                        <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:10px;">
                            <div style="color:#7777aa; font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">
                                {{ $payment->wallet_name ?? 'Wallet Address' }}
                            </div>
                            <div style="color:#4db8ff; font-size:.85rem; font-weight:700; word-break:break-all; font-family:monospace;">
                                {{ $payment->wallet_address }}
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary w-100"
                            onclick="navigator.clipboard.writeText('{{ $payment->wallet_address }}');this.innerHTML='<i class=\'bi bi-check\'></i> Copied!'">
                            <i class="bi bi-copy me-1"></i>Copy Address
                        </button>
                        @endif

                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Deposit Note from Admin --}}
        @if($payment->deposit_note)
        <div style="background:#0d1a0d; border:1px solid #4cdf80; border-radius:10px; padding:14px; margin-bottom:20px;">
            <div style="color:#4cdf80; font-size:.85rem;">
                <i class="bi bi-info-circle-fill me-2"></i>{{ $payment->deposit_note }}
            </div>
        </div>
        @endif

    @else
        {{-- No payment method set by admin --}}
        <div style="background:#1a1a0d; border:1px solid #f0a500; border-radius:10px; padding:16px; margin-bottom:20px; text-align:center;">
            <i class="bi bi-exclamation-triangle-fill me-2" style="color:#f0a500;"></i>
            <span style="color:#f0a500;">Payment details not configured yet. Please contact support.</span>
        </div>
    @endif

    {{-- Deposit Form --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-send-fill me-2" style="color:#f0a500;"></i>Submit Deposit Details
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('deposit.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" min="100"
                        placeholder="Enter amount you paid" value="{{ old('amount') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Your UPI ID <span style="color:#5a5a80; font-size:.8rem;">(optional)</span></label>
                    <input type="text" name="upi_id" class="form-control"
                        placeholder="yourname@bank" value="{{ old('upi_id') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">UTR / Transaction ID</label>
                    <input type="text" name="utr_number" class="form-control"
                        placeholder="12-digit UTR from your payment app" value="{{ old('utr_number') }}" required>
                    <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                        <i class="bi bi-info-circle me-1"></i>Find UTR in your UPI app → Transaction History
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Payment Screenshot</label>
                    <input type="file" name="screenshot" class="form-control" accept="image/*"
                        required onchange="previewScreenshot(this)">
                    <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                        <i class="bi bi-image me-1"></i>Upload screenshot of successful payment
                    </div>
                    <div id="screenshotPreview" class="mt-2 text-center" style="display:none;">
                        <img id="ssImg" style="max-width:100%; max-height:200px; border-radius:10px; border:1px solid #2a2a50;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-send-fill me-2"></i>Submit Deposit Request
                </button>
            </form>
        </div>
    </div>

</div>
</div>

@endsection
@section('scripts')
<script>
function previewScreenshot(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('ssImg').src = e.target.result;
        document.getElementById('screenshotPreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
