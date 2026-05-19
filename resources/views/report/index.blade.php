@extends('layouts.app')
@section('title', 'Reports')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">📥 Total Deposited</div>
            <div class="stat-value">₹{{ number_format($totalDeposited, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">📤 Total Withdrawn</div>
            <div class="stat-value" style="color:#ff4d4d;">₹{{ number_format($totalWithdrawn, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">💎 Commission Earned</div>
            <div class="stat-value green">₹{{ number_format($totalCommission, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">👥 Referrals</div>
            <div class="stat-value blue">{{ $referralCount }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">📋 Transaction History</div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Wallet</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td><span class="badge bg-secondary">{{ ucfirst($tx->type) }}</span></td>
                    <td style="color:#c0c0e0;">{{ ucfirst($tx->wallet) }}</td>
                    <td class="{{ $tx->direction === 'credit' ? 'text-green' : 'text-red' }}" style="font-weight:700;">
                        {{ $tx->direction === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                    </td>
                    <td style="color:#8888aa; font-size:.85rem;">{{ $tx->description ?? '—' }}</td>
                    <td><span class="badge badge-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $tx->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div style="font-size:2.5rem;">📭</div>
                        <div class="text-muted mt-2">No transactions yet</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
