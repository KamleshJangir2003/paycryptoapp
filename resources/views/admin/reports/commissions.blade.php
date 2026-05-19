@extends('layouts.admin')
@section('title', 'Commission Report')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Total Paid</div>
            <div class="stat-value blue" style="font-size:1.1rem;">₹{{ number_format($stats['total'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📥 On Deposits</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($stats['deposit_comm'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">📤 On Withdrawals</div>
            <div class="stat-value" style="font-size:1.1rem; color:#ff4d4d;">₹{{ number_format($stats['withdrawal_comm'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">🔗 Referral</div>
            <div class="stat-value gold" style="font-size:1.1rem;">₹{{ number_format($stats['referral_comm'], 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card text-center">
            <div class="stat-label">☀️ Today</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($stats['today'], 0) }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>💎 All Commissions</span>
        <span style="color:#7777aa; font-size:.85rem;">Total: {{ $commissions->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>Earner</th><th>From User</th><th>Type</th><th>Txn Amount</th><th>Rate</th><th>Commission</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($commissions as $c)
                <tr>
                    <td>
                        <a href="{{ route('admin.users.show', $c->user) }}" style="color:#4db8ff; text-decoration:none; font-weight:500;">{{ $c->user->name }}</a>
                        <div style="color:#7777aa; font-size:.78rem;">{{ $c->user->mobile }}</div>
                    </td>
                    <td style="color:#c0c0e0; font-size:.88rem;">{{ $c->fromUser?->name ?? 'System' }}</td>
                    <td>
                        <span class="badge"
                            style="background:{{ $c->type === 'deposit' ? '#0d2a1a' : ($c->type === 'withdrawal' ? '#2a0d0d' : '#1a1a0d') }};
                                   color:{{ $c->type === 'deposit' ? '#4cdf80' : ($c->type === 'withdrawal' ? '#ff4d4d' : '#f0a500') }};
                                   border:1px solid {{ $c->type === 'deposit' ? '#4cdf80' : ($c->type === 'withdrawal' ? '#ff4d4d' : '#f0a500') }};">
                            {{ ucfirst($c->type) }}
                        </span>
                    </td>
                    <td style="color:#c0c0e0;">₹{{ number_format($c->transaction_amount, 2) }}</td>
                    <td style="color:#7777aa;">{{ $c->commission_rate }}%</td>
                    <td style="color:#4cdf80; font-weight:700;">+₹{{ number_format($c->commission_amount, 2) }}</td>
                    <td style="color:#7777aa; font-size:.8rem;">{{ $c->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No commissions yet</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $commissions->links() }}</div>

@endsection
