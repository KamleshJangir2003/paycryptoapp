@extends('layouts.admin')
@section('title', 'User Detail')
@section('content')

{{-- User Info Header --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div style="width:60px; height:60px; background:#1a1a38; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.8rem; border:2px solid #2a2a50;">
                👤
            </div>
            <div class="flex-grow-1">
                <div style="font-size:1.3rem; font-weight:700; color:#f0f0f0;">{{ $user->name }}</div>
                <div style="color:#7777aa; font-size:.9rem; font-family:monospace;">{{ $user->mobile }}</div>
                <div class="d-flex gap-3 mt-1 flex-wrap">
                    <span style="color:#5a5a80; font-size:.82rem;">Referral: <span style="color:#f0a500; font-weight:700; letter-spacing:2px;">{{ $user->referral_code }}</span></span>
                    <span style="color:#5a5a80; font-size:.82rem;">Referred by: <span style="color:#c0c0e0;">{{ $user->referredBy?->name ?? 'None' }}</span></span>
                    <span style="color:#5a5a80; font-size:.82rem;">Joined: <span style="color:#c0c0e0;">{{ $user->created_at->format('d M Y') }}</span></span>
                </div>
            </div>
            <div>
                @if($user->is_active)
                <span class="badge px-3 py-2" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80; font-size:.85rem;">● Active</span>
                @else
                <span class="badge px-3 py-2" style="background:#2a0d0d; color:#ff4d4d; border:1px solid #ff4d4d; font-size:.85rem;">● Disabled</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Wallet Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">💰 Main Wallet</div>
            <div class="stat-value gold">₹{{ number_format($user->wallet->main_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">📈 Earnings</div>
            <div class="stat-value green">₹{{ number_format($user->wallet->earnings_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">⏳ Pending</div>
            <div class="stat-value orange">₹{{ number_format($user->wallet->pending_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">👥 Referrals</div>
            <div class="stat-value blue">{{ $user->referrals->count() }}</div>
        </div>
    </div>
</div>

{{-- Payment Details --}}
@if($user->upi_id || $user->bank_account)
<div class="card mb-4">
    <div class="card-header">💳 Payment Details</div>
    <div class="card-body">
        <div class="row g-3">
            @if($user->upi_id)
            <div class="col-md-4">
                <div style="color:#7777aa; font-size:.8rem; font-weight:600; text-transform:uppercase;">UPI ID</div>
                <div style="color:#f0a500; font-family:monospace;">{{ $user->upi_id }}</div>
            </div>
            @endif
            @if($user->bank_account)
            <div class="col-md-4">
                <div style="color:#7777aa; font-size:.8rem; font-weight:600; text-transform:uppercase;">Bank Account</div>
                <div style="color:#c0c0e0; font-family:monospace;">{{ $user->bank_account }}</div>
                <div style="color:#7777aa; font-size:.8rem;">{{ $user->bank_ifsc }} • {{ $user->bank_name }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Deposits & Withdrawals --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>📥 Recent Deposits</span>
                <span style="color:#7777aa; font-size:.82rem;">{{ $user->deposits->count() }} total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Amount</th><th>UTR</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($user->deposits->take(5) as $d)
                        <tr>
                            <td style="color:#f0a500; font-weight:600;">₹{{ number_format($d->amount, 2) }}</td>
                            <td style="color:#c0c0e0; font-size:.82rem; font-family:monospace;">{{ $d->utr_number ?? '—' }}</td>
                            <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.8rem;">{{ $d->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-3 text-muted">No deposits</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>📤 Recent Withdrawals</span>
                <span style="color:#7777aa; font-size:.82rem;">{{ $user->withdrawals->count() }} total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($user->withdrawals->take(5) as $w)
                        <tr>
                            <td style="color:#ff4d4d; font-weight:600;">₹{{ number_format($w->amount, 2) }}</td>
                            <td><span class="badge bg-secondary">{{ strtoupper($w->method) }}</span></td>
                            <td><span class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.8rem;">{{ $w->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-3 text-muted">No withdrawals</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Actions --}}
<div class="card mb-4">
    <div class="card-header">⚙️ Actions</div>
    <div class="card-body d-flex gap-3 flex-wrap">
        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
            @csrf
            <button class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                <i class="bi bi-{{ $user->is_active ? 'slash-circle' : 'check-circle' }} me-1"></i>
                {{ $user->is_active ? 'Disable Account' : 'Enable Account' }}
            </button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Users
        </a>
    </div>
</div>

{{-- Wallet Adjustment --}}
<div class="card">
    <div class="card-header">💰 Manual Wallet Adjustment</div>
    <div class="card-body">
        <div style="background:#2a1a0d; border:1px solid #ff9800; border-radius:10px; padding:12px; margin-bottom:16px;">
            <div style="color:#ff9800; font-size:.85rem;"><i class="bi bi-exclamation-triangle-fill me-2"></i>Use carefully. All adjustments are logged in transaction history.</div>
        </div>
        <form method="POST" action="{{ route('admin.users.wallet.adjust', $user) }}">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Wallet</label>
                    <select name="wallet" class="form-select" required>
                        <option value="main">Main Wallet (₹{{ number_format($user->wallet->main_balance, 2) }})</option>
                        <option value="earnings">Earnings Wallet (₹{{ number_format($user->wallet->earnings_balance, 2) }})</option>
                        <option value="pending">Pending Wallet (₹{{ number_format($user->wallet->pending_balance, 2) }})</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label">Type</label>
                    <select name="direction" class="form-select" required>
                        <option value="credit">➕ Credit</option>
                        <option value="debit">➖ Debit</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" min="1" placeholder="0" required>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Reason</label>
                    <input type="text" name="reason" class="form-control" placeholder="Reason for adjustment" required>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Adjust</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
