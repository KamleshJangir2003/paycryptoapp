@extends('layouts.app')
@section('title', 'Finance Report')
@section('content')

{{-- Summary Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">📥 Total Deposited</div>
            <div class="stat-value" style="font-size:1.1rem;">₹{{ number_format($totalDeposited, 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">📤 Total Withdrawn</div>
            <div class="stat-value" style="font-size:1.1rem; color:#ff4d4d;">₹{{ number_format($totalWithdrawn, 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Commission</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($totalCommission, 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">📅 This Month Dep</div>
            <div class="stat-value" style="font-size:1.1rem; color:#4db8ff;">₹{{ number_format($thisMonthDep, 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">📅 This Month With</div>
            <div class="stat-value" style="font-size:1.1rem; color:#ff9800;">₹{{ number_format($thisMonthWith, 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card text-center">
            <div class="stat-label">☀️ Today Deposit</div>
            <div class="stat-value green" style="font-size:1.1rem;">₹{{ number_format($todayDep, 0) }}</div>
        </div>
    </div>
</div>

{{-- Net Balance Card --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; margin-bottom:4px;">Net Balance (Deposited - Withdrawn)</div>
                @php $net = $totalDeposited - $totalWithdrawn; @endphp
                <div style="font-size:1.6rem; font-weight:800; color:{{ $net >= 0 ? '#4cdf80' : '#ff4d4d' }};">
                    {{ $net >= 0 ? '+' : '' }}₹{{ number_format($net, 2) }}
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div style="color:#8888aa; font-size:.82rem; margin-bottom:4px;">Main Wallet</div>
                <div style="font-size:1.3rem; font-weight:700; color:#f0a500;">₹{{ number_format($user->wallet->main_balance, 2) }}</div>
            </div>
            <div class="col-12 col-md-4">
                <div style="color:#8888aa; font-size:.82rem; margin-bottom:4px;">Earnings Wallet</div>
                <div style="font-size:1.3rem; font-weight:700; color:#4cdf80;">₹{{ number_format($user->wallet->earnings_balance, 2) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Tabs --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex gap-2 flex-wrap">
            @php
            $filters = [
                'all'        => ['label' => 'All', 'icon' => 'bi-list-ul'],
                'today'      => ['label' => 'Today', 'icon' => 'bi-sun'],
                'this_month' => ['label' => 'This Month', 'icon' => 'bi-calendar-month'],
                'deposit'    => ['label' => 'Deposits', 'icon' => 'bi-arrow-down-circle'],
                'withdrawal' => ['label' => 'Withdrawals', 'icon' => 'bi-arrow-up-circle'],
                'commission' => ['label' => 'Commission', 'icon' => 'bi-gem'],
            ];
            @endphp
            @foreach($filters as $key => $f)
            <a href="{{ route('reports.finance', ['filter' => $key]) }}"
                class="btn btn-sm {{ $filter === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi {{ $f['icon'] }} me-1"></i>{{ $f['label'] }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Wallet</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $tx->id }}</td>
                    <td>
                        <span class="badge"
                            style="background:{{ $tx->type === 'deposit' ? '#0d2a1a' : ($tx->type === 'withdrawal' ? '#2a0d0d' : '#1a1a0d') }};
                                   color:{{ $tx->type === 'deposit' ? '#4cdf80' : ($tx->type === 'withdrawal' ? '#ff4d4d' : '#f0a500') }};
                                   border:1px solid {{ $tx->type === 'deposit' ? '#4cdf80' : ($tx->type === 'withdrawal' ? '#ff4d4d' : '#f0a500') }};">
                            {{ ucfirst($tx->type) }}
                        </span>
                    </td>
                    <td style="color:#c0c0e0; font-size:.85rem;">{{ ucfirst($tx->wallet) }}</td>
                    <td style="font-weight:700; color:{{ $tx->direction === 'credit' ? '#4cdf80' : '#ff4d4d' }};">
                        {{ $tx->direction === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                    </td>
                    <td style="color:#8888aa; font-size:.82rem; max-width:180px;">{{ $tx->description ?? '—' }}</td>
                    <td><span class="badge badge-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.8rem;">
                        {{ $tx->created_at->format('d M Y') }}<br>
                        <span style="color:#5a5a80;">{{ $tx->created_at->format('h:i A') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="font-size:2.5rem;">📭</div>
                        <div class="text-muted mt-2">No transactions found</div>
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
