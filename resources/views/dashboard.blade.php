@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- Wallet Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">💰 Main Wallet</div>
            <div class="stat-value">₹{{ number_format($user->wallet->main_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">📈 Earnings</div>
            <div class="stat-value green">₹{{ number_format($user->wallet->earnings_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">⏳ Pending</div>
            <div class="stat-value orange">₹{{ number_format($user->wallet->pending_balance, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">👥 Referrals</div>
            <div class="stat-value blue">{{ $referralCount }}</div>
        </div>
    </div>
</div>

{{-- Performance Bonus --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🏆 Performance Commission</span>
        <span class="text-muted" style="font-size:.85rem;">Daily Target: <span class="text-gold">₹{{ number_format($performanceTarget, 0) }}</span></span>
    </div>
    <div class="card-body">
        @php $pct = $performanceTarget > 0 ? min(100, ($todayVolume / $performanceTarget) * 100) : 0; @endphp
        <div class="d-flex justify-content-between mb-2">
            <span style="color:#c0c0e0; font-size:.9rem;">Today's Volume</span>
            <span class="text-gold fw-bold">₹{{ number_format($todayVolume, 2) }} <span class="text-muted">/ ₹{{ number_format($performanceTarget, 0) }}</span></span>
        </div>
        <div class="progress mb-2" style="height:12px;">
            <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $pct >= 100 ? '#4cdf80' : '#f0a500' }}; border-radius:10px; transition:width .5s;"></div>
        </div>
        @if($pct >= 100)
            <div class="text-green small"><i class="bi bi-check-circle-fill me-1"></i>Target achieved! Bonus credited to Earnings Wallet.</div>
        @else
            <div style="color:#8888aa; font-size:.85rem;"><i class="bi bi-info-circle me-1"></i>₹{{ number_format($performanceTarget - $todayVolume, 2) }} more needed to unlock performance bonus.</div>
        @endif
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <a href="{{ route('referral') }}" class="card p-3 text-decoration-none d-block">
            <div class="d-flex align-items-center gap-3">
                <div style="font-size:2rem;">🔗</div>
                <div class="flex-grow-1">
                    <div style="color:#8888aa; font-size:.8rem; font-weight:600; text-transform:uppercase;">Your Referral Code</div>
                    <div style="font-size:1.4rem; font-weight:800; color:#f0a500; letter-spacing:4px; font-family:monospace;">{{ $user->referral_code }}</div>
                    <div style="color:#4cdf80; font-size:.8rem; margin-top:2px;">{{ $referralCount }} referrals • Tap to share →</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('deposit.create') }}" class="card p-3 text-decoration-none d-flex flex-column align-items-center justify-content-center" style="min-height:90px;">
            <div style="font-size:1.8rem;">💰</div>
            <div class="text-gold fw-bold mt-1">Deposit</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('withdrawal.create') }}" class="card p-3 text-decoration-none d-flex flex-column align-items-center justify-content-center" style="min-height:90px;">
            <div style="font-size:1.8rem;">🏦</div>
            <div class="text-gold fw-bold mt-1">Withdraw</div>
        </a>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📋 Recent Transactions</span>
        <a href="{{ route('reports') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Wallet</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $tx)
                <tr>
                    <td><span class="badge bg-secondary">{{ ucfirst($tx->type) }}</span></td>
                    <td style="color:#c0c0e0;">{{ ucfirst($tx->wallet) }}</td>
                    <td class="{{ $tx->direction === 'credit' ? 'text-green' : 'text-red' }}" style="font-weight:600;">
                        {{ $tx->direction === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                    </td>
                    <td><span class="badge badge-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td style="color:#8888aa; font-size:.85rem;">{{ $tx->created_at->format('d M, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="font-size:2rem;">📭</div>
                        <div class="text-muted mt-2">No transactions yet</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection
