@extends('layouts.app')
@section('title', 'Adjustment')
@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-card text-center">
            <div class="stat-label">🔒 Active Security Hold</div>
            <div class="stat-value orange">₹{{ number_format($securityHolds, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card text-center">
            <div class="stat-label">🎁 Total Bonuses Received</div>
            <div class="stat-value green">₹{{ number_format($totalBonuses, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card text-center">
            <div class="stat-label">⏳ Pending Wallet</div>
            <div class="stat-value orange">₹{{ number_format($user->wallet->pending_balance, 2) }}</div>
        </div>
    </div>
</div>

{{-- What is Adjustment --}}
<div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:12px; padding:16px; margin-bottom:20px;">
    <div style="color:#f0a500; font-weight:600; margin-bottom:10px;"><i class="bi bi-info-circle-fill me-2"></i>Adjustment kya hota hai?</div>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div style="color:#c0c0e0; font-size:.88rem;">
                <span style="color:#ff9800; font-weight:600;">🔒 Security Hold</span><br>
                <span style="color:#7777aa;">Dispute ya suspicious activity par temporarily amount hold kiya jata hai.</span>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div style="color:#c0c0e0; font-size:.88rem;">
                <span style="color:#4cdf80; font-weight:600;">✅ Security Release</span><br>
                <span style="color:#7777aa;">Hold amount resolve hone par wapas wallet mein credit hota hai.</span>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div style="color:#c0c0e0; font-size:.88rem;">
                <span style="color:#f0a500; font-weight:600;">🎁 Bonus</span><br>
                <span style="color:#7777aa;">Performance target achieve karne par ya special occasion par bonus milta hai.</span>
            </div>
        </div>
    </div>
</div>

{{-- Security Holds List --}}
@if($user->securityHolds->count() > 0)
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🔒 Security Holds</span>
        <span style="color:#ff9800; font-size:.85rem;">Active: ₹{{ number_format($securityHolds, 2) }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>Amount</th><th>Type</th><th>Reason</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                @foreach($user->securityHolds as $hold)
                <tr>
                    <td style="color:#ff9800; font-weight:700;">₹{{ number_format($hold->amount, 2) }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($hold->type) }}</span></td>
                    <td style="color:#c0c0e0; font-size:.85rem;">{{ $hold->reason }}</td>
                    <td>
                        @if($hold->status === 'held')
                            <span class="badge" style="background:#2a1a0d; color:#ff9800; border:1px solid #ff9800;">🔒 Held</span>
                        @elseif($hold->status === 'released')
                            <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">✅ Released</span>
                        @else
                            <span class="badge" style="background:#2a0d0d; color:#ff4d4d; border:1px solid #ff4d4d;">❌ Forfeited</span>
                        @endif
                    </td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $hold->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endif

{{-- Adjustment Transactions --}}
<div class="card">
    <div class="card-header">📋 Adjustment History</div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adjustments as $tx)
                <tr>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $tx->id }}</td>
                    <td>
                        @if($tx->type === 'security_hold')
                            <span class="badge" style="background:#2a1a0d; color:#ff9800; border:1px solid #ff9800;">🔒 Security Hold</span>
                        @elseif($tx->type === 'security_release')
                            <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">✅ Released</span>
                        @else
                            <span class="badge" style="background:#1a1a0d; color:#f0a500; border:1px solid #f0a500;">🎁 Bonus</span>
                        @endif
                    </td>
                    <td style="font-weight:700; color:{{ $tx->direction === 'credit' ? '#4cdf80' : '#ff4d4d' }};">
                        {{ $tx->direction === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                    </td>
                    <td style="color:#8888aa; font-size:.82rem;">{{ $tx->description ?? '—' }}</td>
                    <td><span class="badge badge-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.8rem;">
                        {{ $tx->created_at->format('d M Y') }}<br>
                        <span style="color:#5a5a80;">{{ $tx->created_at->format('h:i A') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div style="font-size:2.5rem;">📋</div>
                        <div class="text-muted mt-2">No adjustments yet</div>
                        <div style="color:#5a5a80; font-size:.85rem; margin-top:4px;">Security holds aur bonuses yahan dikhenge</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $adjustments->links() }}</div>

{{-- Contact Support --}}
<div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:12px; padding:16px; margin-top:20px; text-align:center;">
    <div style="color:#c0c0e0; font-size:.9rem; margin-bottom:10px;">
        <i class="bi bi-info-circle me-1" style="color:#f0a500;"></i>
        Koi adjustment galat lage ya security hold ke baare mein jaanna ho?
    </div>
    <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-headset me-1"></i>Contact Support
    </a>
</div>

@endsection
