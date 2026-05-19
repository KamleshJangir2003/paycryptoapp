@extends('layouts.app')
@section('title', 'Bank Details')
@section('content')

<div class="row justify-content-center">
<div class="col-12 col-md-7 col-lg-6">

    <div class="card">
        <div class="card-header">🏦 Bank & UPI Details</div>
        <div class="card-body">

            <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:20px;">
                <div style="color:#7777aa; font-size:.85rem;">
                    <i class="bi bi-info-circle-fill me-2" style="color:#f0a500;"></i>
                    Yeh details withdrawal ke time automatically fill ho jaati hain. Sahi details save karo taaki payment mein koi problem na ho.
                </div>
            </div>

            <form method="POST" action="{{ route('settings.profile') }}">
                @csrf

                {{-- UPI Section --}}
                <div style="color:#f0a500; font-weight:600; font-size:.9rem; margin-bottom:12px; text-transform:uppercase; letter-spacing:.5px;">
                    📱 UPI Details
                </div>
                <div class="mb-4">
                    <label class="form-label">UPI ID</label>
                    <input type="text" name="upi_id" class="form-control"
                        placeholder="yourname@bank / yourname@upi"
                        value="{{ auth()->user()->upi_id }}">
                    <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                        <i class="bi bi-info-circle me-1"></i>e.g. 9876543210@ybl, name@okaxis
                    </div>
                </div>

                <hr style="border-color:#2a2a50; margin: 20px 0;">

                {{-- Bank Section --}}
                <div style="color:#4db8ff; font-weight:600; font-size:.9rem; margin-bottom:12px; text-transform:uppercase; letter-spacing:.5px;">
                    🏦 Bank Account Details
                </div>
                <div class="mb-3">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="bank_account" class="form-control"
                        placeholder="Enter bank account number"
                        value="{{ auth()->user()->bank_account }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">IFSC Code</label>
                    <input type="text" name="bank_ifsc" class="form-control"
                        placeholder="e.g. SBIN0001234"
                        value="{{ auth()->user()->bank_ifsc }}"
                        style="text-transform:uppercase;">
                    <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                        <i class="bi bi-info-circle me-1"></i>11-character IFSC code (cheque book ya passbook pe milega)
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control"
                        placeholder="e.g. State Bank of India"
                        value="{{ auth()->user()->bank_name }}">
                </div>

                {{-- Hidden name field required by controller --}}
                <input type="hidden" name="name" value="{{ auth()->user()->name }}">

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-save-fill me-2"></i>Save Bank Details
                </button>
            </form>
        </div>
    </div>

    {{-- Current Saved Details Preview --}}
    @if(auth()->user()->upi_id || auth()->user()->bank_account)
    <div class="card mt-4">
        <div class="card-header">✅ Currently Saved Details</div>
        <div class="card-body">
            <div class="row g-3">
                @if(auth()->user()->upi_id)
                <div class="col-12">
                    <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px;">
                        <div style="color:#7777aa; font-size:.78rem; font-weight:600; text-transform:uppercase; margin-bottom:4px;">UPI ID</div>
                        <div style="color:#f0a500; font-weight:700; font-family:monospace;">{{ auth()->user()->upi_id }}</div>
                    </div>
                </div>
                @endif
                @if(auth()->user()->bank_account)
                <div class="col-12">
                    <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px;">
                        <div style="color:#7777aa; font-size:.78rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Bank Account</div>
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <div>
                                <div style="color:#c0c0e0; font-family:monospace; font-weight:600;">{{ auth()->user()->bank_account }}</div>
                                <div style="color:#7777aa; font-size:.82rem;">{{ auth()->user()->bank_name }}</div>
                            </div>
                            <div style="color:#4db8ff; font-family:monospace; font-size:.9rem;">{{ auth()->user()->bank_ifsc }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
</div>

@endsection
