@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- USDT Rate Bar --}}
<div class="d-flex align-items-center gap-3 mb-4 px-3 py-2" style="background:linear-gradient(90deg,#0a1a12,#0d1f18); border:1px solid #26a17b55; border-radius:12px;">
    <div style="width:32px;height:32px;background:#26a17b;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:900;color:#fff;font-size:1rem;">₮</div>
    <div>
        <div style="color:#5a8a70;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Current USDT Rate</div>
        <div style="font-size:1rem;font-weight:800;"><span style="color:#26a17b;">1 USDT</span> <span style="color:#5a5a80;">=</span> <span style="color:#f0a500;">₹{{ number_format($usdtRate, 2) }}</span></div>
    </div>
    <a href="{{ route('admin.payment.settings') }}" class="ms-auto btn btn-sm" style="background:#0a1a12;border:1px solid #26a17b44;color:#26a17b;font-size:.78rem;">
        <i class="bi bi-pencil-fill me-1"></i>Change Rate
    </a>
</div>

{{-- Stats Row 1: Users & Pending --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">👥 Total Users</div>
            <div class="stat-value gold">{{ $stats['total_users'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">⏳ Pending Deposits</div>
            <div class="stat-value orange">{{ $stats['pending_deposits'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">⏳ Pending Withdrawals</div>
            <div class="stat-value orange">{{ $stats['pending_withdrawals'] }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Commission</div>
            <div class="stat-value blue" style="font-size:1.1rem;">₹{{ number_format($stats['total_commission'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📤 Total Withdrawn</div>
            <div class="stat-value" style="color:#ff4d4d;font-size:1.1rem;">₹{{ number_format($stats['total_withdrawn'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📥 Total Deposited</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($stats['total_deposited'], 0) }}</div>
        </div>
    </div>
</div>

{{-- USDT Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-card" style="border-color:#26a17b44;background:linear-gradient(135deg,#0a1a12,#0d1f18);">
            <div class="stat-label" style="color:#3a6a50;">₮ Total USDT Deposited</div>
            <div style="font-size:1.6rem;font-weight:900;color:#26a17b;line-height:1.1;">{{ number_format($stats['total_usdt_deposited'], 4) }} <span style="font-size:.9rem;font-weight:500;">USDT</span></div>
            <div style="color:#5a8a70;font-size:.8rem;margin-top:4px;">≈ ₹{{ number_format($stats['total_usdt_deposited'] * $usdtRate, 0) }} INR</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card" style="border-color:#f0a50044;">
            <div class="stat-label" style="color:#8a7030;">📱 UPI Deposits (INR)</div>
            <div style="font-size:1.6rem;font-weight:900;color:#f0a500;line-height:1.1;">₹{{ number_format($stats['total_upi_deposited'], 0) }}</div>
            <div style="color:#8a7030;font-size:.8rem;margin-top:4px;">≈ {{ number_format($usdtRate > 0 ? $stats['total_upi_deposited'] / $usdtRate : 0, 2) }} USDT equivalent</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card" style="border-color:#4db8ff44;">
            <div class="stat-label" style="color:#2a6a8a;">💰 Combined Total</div>
            <div style="font-size:1.6rem;font-weight:900;color:#4db8ff;line-height:1.1;">₹{{ number_format($stats['total_deposited'], 0) }}</div>
            <div style="color:#2a6a8a;font-size:.8rem;margin-top:4px;">≈ {{ number_format($usdtRate > 0 ? $stats['total_deposited'] / $usdtRate : 0, 2) }} USDT total</div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.deposits.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">📥</div>
            <div>
                <div style="color:#f0f0f0;font-weight:600;">Deposits</div>
                @if($stats['pending_deposits'] > 0)
                <div style="color:#ff9800;font-size:.82rem;">{{ $stats['pending_deposits'] }} pending</div>
                @else
                <div style="color:#4cdf80;font-size:.82rem;">All clear</div>
                @endif
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.withdrawals.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">📤</div>
            <div>
                <div style="color:#f0f0f0;font-weight:600;">Withdrawals</div>
                @if($stats['pending_withdrawals'] > 0)
                <div style="color:#ff9800;font-size:.82rem;">{{ $stats['pending_withdrawals'] }} in pool</div>
                @else
                <div style="color:#4cdf80;font-size:.82rem;">Pool empty</div>
                @endif
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.users.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">👥</div>
            <div>
                <div style="color:#f0f0f0;font-weight:600;">Users</div>
                <div style="color:#7777aa;font-size:.82rem;">{{ $stats['total_users'] }} registered</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.payment.settings') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">⚙️</div>
            <div>
                <div style="color:#f0f0f0;font-weight:600;">Payment Settings</div>
                <div style="color:#26a17b;font-size:.82rem;">Rate: ₹{{ number_format($usdtRate, 2) }}/USDT</div>
            </div>
        </a>
    </div>
</div>

{{-- Recent Tables --}}
<div class="row g-3">
    {{-- Recent Deposits --}}
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>📥 Recent Deposits</span>
                <a href="{{ route('admin.deposits.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr><th>User</th><th>Amount</th><th>Type</th><th>Status</th><th>Time</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentDeposits as $d)
                        <tr>
                            <td>
                                <div style="color:#f0f0f0;font-weight:500;">{{ $d->user->name }}</div>
                                <div style="color:#7777aa;font-size:.78rem;">{{ $d->user->mobile }}</div>
                            </td>
                            <td>
                                <div style="color:#f0a500;font-weight:700;">₹{{ number_format($d->amount, 2) }}</div>
                                @if($d->payment_type === 'usdt' && $d->usdt_amount)
                                <div style="color:#26a17b;font-size:.78rem;">{{ number_format($d->usdt_amount, 4) }} USDT</div>
                                @endif
                            </td>
                            <td>
                                @if($d->payment_type === 'usdt')
                                    <span class="badge" style="background:#0a1a12;border:1px solid #26a17b;color:#26a17b;">₮ USDT</span>
                                @else
                                    <span class="badge" style="background:#1a1200;border:1px solid #f0a500;color:#f0a500;">📱 UPI</span>
                                @endif
                            </td>
                            <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                            <td style="color:#7777aa;font-size:.78rem;">{{ $d->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No deposits yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Withdrawals --}}
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>📤 Recent Withdrawals</span>
                <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr><th>User</th><th>Amount (INR)</th><th>≈ USDT</th><th>Status</th><th>Time</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentWithdrawals as $w)
                        <tr>
                            <td>
                                <div style="color:#f0f0f0;font-weight:500;">{{ $w->user->name }}</div>
                                <div style="color:#7777aa;font-size:.78rem;">{{ $w->user->mobile }}</div>
                            </td>
                            <td style="color:#ff4d4d;font-weight:700;">₹{{ number_format($w->amount, 2) }}</td>
                            <td style="color:#26a17b;font-size:.85rem;">{{ number_format($usdtRate > 0 ? $w->amount / $usdtRate : 0, 4) }}</td>
                            <td><span class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span></td>
                            <td style="color:#7777aa;font-size:.78rem;">{{ $w->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No withdrawals yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
