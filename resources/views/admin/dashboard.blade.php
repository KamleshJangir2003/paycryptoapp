@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
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
            <div class="stat-label">📥 Total Deposited</div>
            <div class="stat-value green" style="font-size:1.2rem;">₹{{ number_format($stats['total_deposited'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📤 Total Withdrawn</div>
            <div class="stat-value" style="font-size:1.2rem;">₹{{ number_format($stats['total_withdrawn'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Commission</div>
            <div class="stat-value blue" style="font-size:1.2rem;">₹{{ number_format($stats['total_commission'], 0) }}</div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.deposits.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">📥</div>
            <div>
                <div style="color:#f0f0f0; font-weight:600;">Deposits</div>
                @if($stats['pending_deposits'] > 0)
                <div style="color:#ff9800; font-size:.82rem;">{{ $stats['pending_deposits'] }} pending</div>
                @else
                <div style="color:#4cdf80; font-size:.82rem;">All clear</div>
                @endif
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.withdrawals.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">📤</div>
            <div>
                <div style="color:#f0f0f0; font-weight:600;">Withdrawals</div>
                @if($stats['pending_withdrawals'] > 0)
                <div style="color:#ff9800; font-size:.82rem;">{{ $stats['pending_withdrawals'] }} in pool</div>
                @else
                <div style="color:#4cdf80; font-size:.82rem;">Pool empty</div>
                @endif
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.users.index') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">👥</div>
            <div>
                <div style="color:#f0f0f0; font-weight:600;">Users</div>
                <div style="color:#7777aa; font-size:.82rem;">{{ $stats['total_users'] }} registered</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.payment.settings') }}" class="card p-3 text-decoration-none d-flex align-items-center gap-3">
            <div style="font-size:1.8rem;">⚙️</div>
            <div>
                <div style="color:#f0f0f0; font-weight:600;">Payment Settings</div>
                <div style="color:#7777aa; font-size:.82rem;">QR & UPI config</div>
            </div>
        </a>
    </div>
</div>

{{-- Recent Tables --}}
<div class="row g-3">
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
                        <tr><th>User</th><th>Amount</th><th>Status</th><th>Time</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentDeposits as $d)
                        <tr>
                            <td>
                                <div style="color:#f0f0f0; font-weight:500;">{{ $d->user->name }}</div>
                                <div style="color:#7777aa; font-size:.8rem;">{{ $d->user->mobile }}</div>
                            </td>
                            <td style="color:#f0a500; font-weight:700;">₹{{ number_format($d->amount, 2) }}</td>
                            <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.8rem;">{{ $d->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No deposits yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

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
                        <tr><th>User</th><th>Amount</th><th>Status</th><th>Time</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentWithdrawals as $w)
                        <tr>
                            <td>
                                <div style="color:#f0f0f0; font-weight:500;">{{ $w->user->name }}</div>
                                <div style="color:#7777aa; font-size:.8rem;">{{ $w->user->mobile }}</div>
                            </td>
                            <td style="color:#ff4d4d; font-weight:700;">₹{{ number_format($w->amount, 2) }}</td>
                            <td><span class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.8rem;">{{ $w->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No withdrawals yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
