@extends('layouts.app')
@section('title', 'New Withdrawal')
@section('content')

<div class="row justify-content-center">
<div class="col-12 col-md-7 col-lg-6">

    {{-- Balance Info --}}
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="stat-card text-center" style="padding:12px 8px;">
                <div class="stat-label" style="font-size:.72rem;">Available Balance</div>
                <div style="font-size:1.1rem;font-weight:800;color:#f0a500;word-break:break-all;line-height:1.2;margin:4px 0;">₹{{ number_format($user->wallet->main_balance, 2) }}</div>
                <div style="color:#26a17b;font-size:.7rem;margin-top:2px;">≈ {{ number_format($usdtRate > 0 ? $user->wallet->main_balance / $usdtRate : 0, 2) }} USDT</div>
            </div>
        </div>
        <div class="col-6">
            <div class="stat-card text-center" style="padding:12px 8px;">
                <div class="stat-label" style="font-size:.72rem;">Pending</div>
                <div style="font-size:1.1rem;font-weight:800;color:#ff9800;word-break:break-all;line-height:1.2;margin:4px 0;">₹{{ number_format($user->wallet->pending_balance, 2) }}</div>
                <div style="color:#26a17b;font-size:.7rem;margin-top:2px;">≈ {{ number_format($usdtRate > 0 ? $user->wallet->pending_balance / $usdtRate : 0, 2) }} USDT</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">🏦 Withdrawal Details</div>
        <div class="card-body">
            <form method="POST" action="{{ route('withdrawal.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount (₹ INR)</label>
                    <input type="number" name="amount" id="wdAmount" class="form-control" min="100" placeholder="Minimum ₹100" value="{{ old('amount') }}" required>
                    <div id="wdUsdtDisplay" class="mt-2 px-3 py-2" style="background:#0a1a12;border:1px solid #26a17b33;border-radius:8px;display:none;">
                        <span style="color:#5a8a70;font-size:.8rem;">You will withdraw ≈ </span>
                        <span id="wdUsdtVal" style="color:#26a17b;font-weight:700;"></span>
                        <span style="color:#3a6a50;font-size:.8rem;"> USDT</span>
                        <span style="color:#5a5a80;font-size:.75rem;"> (1 USDT = ₹{{ number_format($usdtRate, 2) }})</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <div class="d-flex gap-3">
                        <label class="flex-fill" style="cursor:pointer;">
                            <input type="radio" name="method" value="upi" {{ old('method','upi') == 'upi' ? 'checked' : '' }} class="d-none method-radio" id="upiRadio">
                            <div class="info-box text-center method-option {{ old('method','upi') == 'upi' ? 'selected' : '' }}" style="border-radius:10px; padding:14px; cursor:pointer;">
                                <div style="font-size:1.5rem;">📱</div>
                                <div style="color:#c0c0e0; font-weight:600; font-size:.9rem;">UPI</div>
                            </div>
                        </label>
                        <label class="flex-fill" style="cursor:pointer;">
                            <input type="radio" name="method" value="bank" {{ old('method') == 'bank' ? 'checked' : '' }} class="d-none method-radio" id="bankRadio">
                            <div class="info-box text-center method-option {{ old('method') == 'bank' ? 'selected' : '' }}" style="border-radius:10px; padding:14px; cursor:pointer;">
                                <div style="font-size:1.5rem;">🏦</div>
                                <div style="color:#c0c0e0; font-weight:600; font-size:.9rem;">Bank Transfer</div>
                            </div>
                        </label>
                        <label class="flex-fill" style="cursor:pointer;">
                            <input type="radio" name="method" value="qr" {{ old('method') == 'qr' ? 'checked' : '' }} class="d-none method-radio" id="qrRadio">
                            <div class="info-box text-center method-option {{ old('method') == 'qr' ? 'selected' : '' }}" style="border-radius:10px; padding:14px; cursor:pointer;">
                                <div style="font-size:1.5rem;">📷</div>
                                <div style="color:#c0c0e0; font-weight:600; font-size:.9rem;">QR Payment</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="upiFields">
                    <div class="mb-3">
                        <label class="form-label">UPI ID</label>
                        <input type="text" name="upi_id" class="form-control" placeholder="yourname@bank" value="{{ old('upi_id', $user->upi_id) }}">
                    </div>
                </div>

                <div id="bankFields" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="bank_account" class="form-control" placeholder="Enter account number" value="{{ old('bank_account', $user->bank_account) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" name="bank_ifsc" class="form-control" placeholder="e.g. SBIN0001234" value="{{ old('bank_ifsc', $user->bank_ifsc) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" placeholder="e.g. State Bank of India" value="{{ old('bank_name', $user->bank_name) }}">
                    </div>
                </div>

                <div id="qrFields" style="display:none;">
                    <div style="background:#0d1a0d; border:1px solid #4cdf80; border-radius:10px; padding:12px; margin-bottom:14px;">
                        <div style="color:#4cdf80; font-size:.85rem;">
                            <i class="bi bi-info-circle-fill me-1"></i>Apna QR code scan karke payment karo, phir screenshot upload karo.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">QR Payment Screenshot <span style="color:#ff4d4d;">*</span></label>
                        <input type="file" name="qr_screenshot" class="form-control" accept="image/*" onchange="previewQR(this)">
                        <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                            <i class="bi bi-image me-1"></i>Payment ke baad QR screenshot upload karo
                        </div>
                        <div id="qrPreview" class="mt-2 text-center" style="display:none;">
                            <img id="qrImg" style="max-width:100%; max-height:220px; border-radius:10px; border:1px solid #2a2a50;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <i class="bi bi-send-fill me-2"></i>Submit Withdrawal Request
                </button>
            </form>
        </div>
    </div>

</div>
</div>
@endsection
@section('scripts')
<style>
.method-option.selected { border-color: #f0a500 !important; background: #1e1e40; }
.method-option.selected div { color: #f0a500 !important; }
</style>
<script>
function showFields(method) {
    document.getElementById('upiFields').style.display  = method === 'upi'  ? 'block' : 'none';
    document.getElementById('bankFields').style.display = method === 'bank' ? 'block' : 'none';
    document.getElementById('qrFields').style.display   = method === 'qr'   ? 'block' : 'none';
    // required toggle
    document.querySelector('[name=qr_screenshot]').required = method === 'qr';
}
document.querySelectorAll('.method-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.method-option').forEach(o => o.classList.remove('selected'));
        this.nextElementSibling.classList.add('selected');
        showFields(this.value);
    });
});
// init
const checked = document.querySelector('.method-radio:checked');
if (checked) showFields(checked.value);

// USDT live converter
const WD_USDT_RATE = {{ $usdtRate }};
document.getElementById('wdAmount').addEventListener('input', function() {
    const val = parseFloat(this.value);
    const box = document.getElementById('wdUsdtDisplay');
    if (!val || val <= 0) { box.style.display = 'none'; return; }
    box.style.display = 'block';
    document.getElementById('wdUsdtVal').textContent = (val / WD_USDT_RATE).toFixed(4);
});

function previewQR(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('qrImg').src = e.target.result;
        document.getElementById('qrPreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
