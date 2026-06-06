@extends('layouts.app')
@section('title', 'New Deposit')
@section('content')

@php $hasDeposit = auth()->user()->deposits()->where('status','approved')->exists(); @endphp
@unless($hasDeposit)
<div class="alert mb-4" style="background:#0d1a2a; border:1px solid #4db8ff; color:#4db8ff; border-radius:12px; padding:16px 20px;">
    <i class="bi bi-info-circle-fill me-2"></i>
    <strong>One step away!</strong> Complete your first deposit to unlock full dashboard access.
</div>
@endunless

{{-- USDT Rate Bar --}}
<div class="d-flex align-items-center gap-3 mb-4 px-3 py-2" style="background:linear-gradient(90deg,#0a1a12,#0d1f18); border:1px solid #26a17b55; border-radius:12px;">
    <div style="width:32px;height:32px;background:#26a17b;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:900;color:#fff;font-size:1rem;">₮</div>
    <div>
        <div style="color:#5a8a70;font-size:.72rem;font-weight:600;text-transform:uppercase;">Current USDT Rate</div>
        <div style="font-size:1rem;font-weight:800;"><span style="color:#26a17b;">1 USDT</span> <span style="color:#5a5a80;">=</span> <span style="color:#f0a500;">₹{{ number_format($usdtRate, 2) }}</span></div>
    </div>
    <div class="ms-auto" style="color:#5a5a80;font-size:.75rem;">Admin controlled</div>
</div>

<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-7">

    {{-- Payment Type Toggle --}}
    <div class="row g-3 mb-4">
        <div class="col-6">
            <label style="cursor:pointer;display:block;">
                <input type="radio" name="pay_type_toggle" value="upi" id="toggleUpi" class="d-none" checked>
                <div class="pay-type-card text-center p-3 selected" id="cardUpi" style="background:#13132b;border:2px solid #f0a500;border-radius:14px;transition:all .2s;">
                    <div style="font-size:1.8rem;">📱</div>
                    <div style="color:#f0a500;font-weight:700;font-size:.95rem;margin-top:4px;">UPI / INR</div>
                    <div style="color:#7777aa;font-size:.75rem;">Pay in Rupees</div>
                </div>
            </label>
        </div>
        <div class="col-6">
            <label style="cursor:pointer;display:block;">
                <input type="radio" name="pay_type_toggle" value="usdt" id="toggleUsdt" class="d-none">
                <div class="pay-type-card text-center p-3" id="cardUsdt" style="background:#13132b;border:2px solid #2a2a50;border-radius:14px;transition:all .2s;">
                    <div style="font-size:1.8rem;">₮</div>
                    <div style="color:#26a17b;font-weight:700;font-size:.95rem;margin-top:4px;">USDT / Crypto</div>
                    <div style="color:#7777aa;font-size:.75rem;">Pay in USDT</div>
                </div>
            </label>
        </div>
    </div>

    {{-- UPI Payment Info --}}
    <div id="upiPaymentInfo">
        @if($payment->upi_active && ($payment->upi_id || $payment->qr_image))
        <div class="card mb-4">
            <div class="card-header text-center">
                <i class="bi bi-phone-fill me-2" style="color:#f0a500;"></i>Pay via UPI
            </div>
            <div class="card-body text-center">
                @if($payment->qr_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$payment->qr_image) }}?v={{ $payment->updated_at->timestamp }}"
                        style="width:190px;height:190px;object-fit:contain;background:#0d0d1a;border:2px solid #2a2a50;border-radius:14px;padding:10px;">
                </div>
                @endif
                @if($payment->upi_id)
                <div style="background:#0d0d1a;border:1px solid #2a2a50;border-radius:10px;padding:14px;margin-bottom:10px;">
                    <div style="color:#7777aa;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">UPI ID</div>
                    <div style="color:#f0a500;font-size:1.1rem;font-weight:800;">{{ $payment->upi_id }}</div>
                    @if($payment->upi_name)<div style="color:#8888aa;font-size:.82rem;margin-top:2px;">{{ $payment->upi_name }}</div>@endif
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary w-100"
                    onclick="navigator.clipboard.writeText('{{ $payment->upi_id }}');this.innerHTML='<i class=\'bi bi-check\'></i> Copied!'">
                    <i class="bi bi-copy me-1"></i>Copy UPI ID
                </button>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- USDT Payment Info --}}
    <div id="usdtPaymentInfo" style="display:none;">
        @if($payment->wallet_active && ($payment->wallet_address || $payment->wallet_qr))
        <div class="card mb-4">
            <div class="card-header text-center">
                <span style="color:#26a17b;font-weight:800;font-size:1rem;">₮</span>
                <span class="ms-2">Pay via {{ $payment->wallet_name ?? 'USDT' }}</span>
            </div>
            <div class="card-body text-center">
                @if($payment->wallet_qr)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$payment->wallet_qr) }}?v={{ $payment->updated_at->timestamp }}"
                        style="width:190px;height:190px;object-fit:contain;background:#0d0d1a;border:2px solid #26a17b44;border-radius:14px;padding:10px;">
                </div>
                @endif
                @if($payment->wallet_address)
                <div style="background:#0a1a12;border:1px solid #26a17b44;border-radius:10px;padding:14px;margin-bottom:10px;">
                    <div style="color:#3a6a50;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">
                        {{ $payment->wallet_name ?? 'Wallet Address' }}
                    </div>
                    <div style="color:#26a17b;font-size:.82rem;font-weight:700;word-break:break-all;font-family:monospace;">
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
        @else
        <div style="background:#1a1a0d;border:1px solid #f0a500;border-radius:10px;padding:16px;margin-bottom:16px;text-align:center;">
            <i class="bi bi-exclamation-triangle-fill me-2" style="color:#f0a500;"></i>
            <span style="color:#f0a500;">USDT wallet not configured. Contact support.</span>
        </div>
        @endif
    </div>

    {{-- Deposit Note --}}
    @if($payment->deposit_note)
    <div style="background:#0d1a0d;border:1px solid #4cdf80;border-radius:10px;padding:14px;margin-bottom:20px;">
        <div style="color:#4cdf80;font-size:.85rem;">
            <i class="bi bi-info-circle-fill me-2"></i>{{ $payment->deposit_note }}
        </div>
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
                <input type="hidden" name="payment_type" id="paymentTypeInput" value="upi">

                {{-- Amount Input --}}
                <div class="mb-3">
                    <label class="form-label" id="amountLabel">Amount (₹ INR)</label>
                    <div class="input-group">
                        <span class="input-group-text" id="amountPrefix" style="background:#1a1a2e;border-color:#3a3a60;color:#f0a500;font-weight:700;">₹</span>
                        <input type="number" name="amount" id="amountInput" class="form-control"
                            min="1" step="0.01" placeholder="Enter amount" value="{{ old('amount') }}" required>
                    </div>
                    {{-- Live Converter --}}
                    <div id="convertedDisplay" class="mt-2 px-3 py-2" style="background:#0a1a12;border:1px solid #26a17b33;border-radius:8px;display:none;">
                        <span style="color:#5a8a70;font-size:.8rem;">≈ </span>
                        <span id="convertedValue" style="color:#26a17b;font-weight:700;font-size:.9rem;"></span>
                        <span id="convertedUnit" style="color:#3a6a50;font-size:.8rem;"></span>
                    </div>
                </div>

                {{-- UPI ID (only for UPI) --}}
                <div class="mb-3" id="upiIdField">
                    <label class="form-label">Your UPI ID <span style="color:#5a5a80;font-size:.8rem;">(optional)</span></label>
                    <input type="text" name="upi_id" class="form-control"
                        placeholder="yourname@bank" value="{{ old('upi_id') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" id="utrLabel">UTR / Transaction ID</label>
                    <input type="text" name="utr_number" class="form-control"
                        placeholder="Transaction ID / Hash" value="{{ old('utr_number') }}" required>
                    <div style="color:#5a5a80;font-size:.78rem;margin-top:4px;" id="utrHint">
                        <i class="bi bi-info-circle me-1"></i>Find UTR in your UPI app → Transaction History
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Payment Screenshot</label>
                    <input type="file" name="screenshot" class="form-control" accept="image/*"
                        required onchange="previewScreenshot(this)">
                    <div style="color:#5a5a80;font-size:.78rem;margin-top:4px;">
                        <i class="bi bi-image me-1"></i>Upload screenshot of successful payment
                    </div>
                    <div id="screenshotPreview" class="mt-2 text-center" style="display:none;">
                        <img id="ssImg" style="max-width:100%;max-height:200px;border-radius:10px;border:1px solid #2a2a50;">
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
const USDT_RATE = {{ $usdtRate }};
let currentType = 'upi';

document.querySelectorAll('input[name="pay_type_toggle"]').forEach(radio => {
    radio.addEventListener('change', function() { switchType(this.value); });
});

// Also allow clicking the card divs
document.getElementById('cardUpi').closest('label').addEventListener('click', () => switchType('upi'));
document.getElementById('cardUsdt').closest('label').addEventListener('click', () => switchType('usdt'));

function switchType(type) {
    currentType = type;
    document.getElementById('paymentTypeInput').value = type;

    const isUsdt = type === 'usdt';

    // Card styles
    document.getElementById('cardUpi').style.borderColor  = isUsdt ? '#2a2a50' : '#f0a500';
    document.getElementById('cardUsdt').style.borderColor = isUsdt ? '#26a17b' : '#2a2a50';

    // Show/hide payment info
    document.getElementById('upiPaymentInfo').style.display  = isUsdt ? 'none' : 'block';
    document.getElementById('usdtPaymentInfo').style.display = isUsdt ? 'block' : 'none';

    // Update labels
    document.getElementById('amountLabel').textContent  = isUsdt ? 'Amount (USDT)' : 'Amount (₹ INR)';
    document.getElementById('amountPrefix').textContent = isUsdt ? '₮' : '₹';
    document.getElementById('amountPrefix').style.color = isUsdt ? '#26a17b' : '#f0a500';
    document.getElementById('amountInput').placeholder  = isUsdt ? 'Enter USDT amount' : 'Enter INR amount';
    document.getElementById('amountInput').min          = isUsdt ? '0.1' : '1';
    document.getElementById('utrLabel').textContent     = isUsdt ? 'Transaction Hash / TxID' : 'UTR / Transaction ID';
    document.getElementById('utrHint').innerHTML        = isUsdt
        ? '<i class="bi bi-info-circle me-1"></i>Find TxID in your crypto wallet / exchange'
        : '<i class="bi bi-info-circle me-1"></i>Find UTR in your UPI app → Transaction History';
    document.getElementById('upiIdField').style.display = isUsdt ? 'none' : 'block';

    updateConverter();
}

document.getElementById('amountInput').addEventListener('input', updateConverter);

function updateConverter() {
    const val = parseFloat(document.getElementById('amountInput').value);
    const box = document.getElementById('convertedDisplay');
    if (!val || val <= 0) { box.style.display = 'none'; return; }

    box.style.display = 'block';
    if (currentType === 'usdt') {
        document.getElementById('convertedValue').textContent = '₹' + (val * USDT_RATE).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
        document.getElementById('convertedUnit').textContent  = ' INR';
    } else {
        document.getElementById('convertedValue').textContent = (val / USDT_RATE).toFixed(4);
        document.getElementById('convertedUnit').textContent  = ' USDT';
    }
}

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
