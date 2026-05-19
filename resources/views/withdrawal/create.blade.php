@extends('layouts.app')
@section('title', 'New Withdrawal')
@section('content')

<div class="row justify-content-center">
<div class="col-12 col-md-7 col-lg-6">

    {{-- Balance Info --}}
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="stat-card text-center">
                <div class="stat-label">Available Balance</div>
                <div class="stat-value">₹{{ number_format($user->wallet->main_balance, 2) }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="stat-card text-center">
                <div class="stat-label">Pending</div>
                <div class="stat-value orange">₹{{ number_format($user->wallet->pending_balance, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">🏦 Withdrawal Details</div>
        <div class="card-body">
            <form method="POST" action="{{ route('withdrawal.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" min="100" placeholder="Minimum ₹100" value="{{ old('amount') }}" required>
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
document.querySelectorAll('.method-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.method-option').forEach(o => o.classList.remove('selected'));
        this.nextElementSibling.classList.add('selected');
        document.getElementById('upiFields').style.display  = this.value === 'upi'  ? 'block' : 'none';
        document.getElementById('bankFields').style.display = this.value === 'bank' ? 'block' : 'none';
    });
});
// init
if(document.getElementById('bankRadio').checked) {
    document.getElementById('upiFields').style.display = 'none';
    document.getElementById('bankFields').style.display = 'block';
}
</script>
@endsection
