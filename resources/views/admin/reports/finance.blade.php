@extends('layouts.admin')
@section('title', 'Finance Report')
@section('content')

{{-- Platform Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">👥 Total Users</div>
            <div class="stat-value gold">{{ $stats['total_users'] }}</div>
            <div style="color:#4cdf80; font-size:.75rem; margin-top:4px;">{{ $stats['active_users'] }} active</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📥 Total Deposited</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($stats['total_deposited'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📤 Total Withdrawn</div>
            <div class="stat-value" style="font-size:1.1rem; color:#ff4d4d;">₹{{ number_format($stats['total_withdrawn'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Commission Paid</div>
            <div class="stat-value blue" style="font-size:1.1rem;">₹{{ number_format($stats['total_commission'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">☀️ Today Deposit</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($stats['today_deposited'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">☀️ Today Withdrawn</div>
            <div class="stat-value" style="font-size:1.1rem; color:#ff4d4d;">₹{{ number_format($stats['today_withdrawn'], 0) }}</div>
        </div>
    </div>
</div>

{{-- Net + Pending --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card p-4 text-center">
            <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Platform Net Balance</div>
            @php $net = $stats['total_deposited'] - $stats['total_withdrawn'] - $stats['total_commission']; @endphp
            <div style="font-size:1.8rem; font-weight:800; color:{{ $net >= 0 ? '#4cdf80' : '#ff4d4d' }};">
                {{ $net >= 0 ? '+' : '' }}₹{{ number_format($net, 2) }}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card p-4 text-center">
            <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">⏳ Pending Deposits</div>
            <div style="font-size:1.8rem; font-weight:800; color:#ff9800;">₹{{ number_format($stats['pending_deposits'], 2) }}</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card p-4 text-center">
            <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">⏳ Pending Withdrawals</div>
            <div style="font-size:1.8rem; font-weight:800; color:#ff9800;">₹{{ number_format($stats['pending_withdrawals'], 2) }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Deposits --}}
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>📥 Recent Deposits</span>
                <a href="{{ route('admin.deposits.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>User</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach($recentDeposits as $d)
                        <tr>
                            <td>
                                <div style="color:#f0f0f0; font-weight:500; font-size:.88rem;">{{ $d->user->name }}</div>
                                <div style="color:#7777aa; font-size:.78rem;">{{ $d->user->mobile }}</div>
                            </td>
                            <td style="color:#f0a500; font-weight:700;">₹{{ number_format($d->amount, 2) }}</td>
                            <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.8rem;">{{ $d->created_at->format('d M, h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Users --}}
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">🏆 Top Users by Deposit</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>#</th><th>User</th><th>Total Deposited</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($topUsers as $i => $u)
                        <tr>
                            <td style="color:#f0a500; font-weight:700;">{{ $i + 1 }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $u) }}" style="color:#4db8ff; text-decoration:none; font-weight:500;">{{ $u->name }}</a>
                                <div style="color:#7777aa; font-size:.78rem;">{{ $u->mobile }}</div>
                            </td>
                            <td style="color:#4cdf80; font-weight:700;">₹{{ number_format($u->total_dep ?? 0, 2) }}</td>
                            <td>
                                <span class="badge" style="background:{{ $u->is_active ? '#0d2a1a' : '#2a0d0d' }}; color:{{ $u->is_active ? '#4cdf80' : '#ff4d4d' }}; border:1px solid {{ $u->is_active ? '#4cdf80' : '#ff4d4d' }};">
                                    {{ $u->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
