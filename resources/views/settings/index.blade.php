@extends('layouts.app')
@section('title', 'Profile Settings')
@section('content')

<div class="row g-4">

    {{-- Profile --}}
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">👤 Profile</div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.profile') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" value="{{ $user->mobile }}" disabled
                            style="opacity:.6; cursor:not-allowed;">
                        <div style="color:#5a5a80; font-size:.78rem; margin-top:4px;">
                            <i class="bi bi-lock me-1"></i>Mobile number cannot be changed
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save-fill me-2"></i>Save Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Right side --}}
    <div class="col-12 col-lg-6">

        {{-- Referral Code --}}
        <div class="card mb-4">
            <div class="card-header">🔗 Your Referral Code</div>
            <div class="card-body text-center py-4">
                <div style="font-size:2rem; font-weight:900; color:#f0a500; letter-spacing:8px; font-family:monospace; margin-bottom:8px;">
                    {{ $user->referral_code }}
                </div>
                <div style="color:#7777aa; font-size:.85rem; margin-bottom:16px;">
                    Earn <span style="color:#4cdf80; font-weight:700;">1%</span> on deposits &
                    <span style="color:#4cdf80; font-weight:700;">0.5%</span> on withdrawals
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary" onclick="navigator.clipboard.writeText('{{ $user->referral_code }}');this.innerHTML='<i class=\'bi bi-check\'></i> Copied!'">
                        <i class="bi bi-copy me-1"></i>Copy Code
                    </button>
                    <a href="{{ route('referral') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-people me-1"></i>View Referrals
                    </a>
                </div>
            </div>
        </div>

        {{-- Security PIN --}}
        <div class="card">
            <div class="card-header">🔐 Security PIN</div>
            <div class="card-body">
                <div style="color:#7777aa; font-size:.85rem; margin-bottom:14px;">
                    <i class="bi bi-info-circle me-1"></i>6-digit PIN for transaction verification
                </div>
                <form method="POST" action="{{ route('settings.pin') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">New PIN (6 digits)</label>
                        <input type="password" name="pin" class="form-control" maxlength="6"
                            placeholder="••••••" pattern="[0-9]{6}" required
                            style="font-size:1.4rem; letter-spacing:8px; text-align:center;">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-key-fill me-2"></i>Set Security PIN
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- Quick Links --}}
    <div class="col-12">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('settings.bank.page') }}" class="card p-3 text-decoration-none text-center d-block">
                    <div style="font-size:1.8rem;">🏦</div>
                    <div style="color:#f0a500; font-weight:600; margin-top:4px; font-size:.9rem;">Bank Details</div>
                    <div style="color:#7777aa; font-size:.78rem;">UPI & Bank account</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('settings.password.page') }}" class="card p-3 text-decoration-none text-center d-block">
                    <div style="font-size:1.8rem;">🔒</div>
                    <div style="color:#f0a500; font-weight:600; margin-top:4px; font-size:.9rem;">Change Password</div>
                    <div style="color:#7777aa; font-size:.78rem;">Update your password</div>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
