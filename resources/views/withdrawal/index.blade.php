@extends('layouts.app')
@section('title', 'Withdrawal')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div style="color:#8888aa; font-size:.9rem;">Manage your withdrawals</div>
    <a href="{{ route('withdrawal.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> New Withdrawal</a>
</div>

<div class="row g-4">

    {{-- History --}}
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">🏦 Withdrawal History</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>UTR</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $w)
                        <tr>
                            <td style="color:#7777aa;">{{ $w->id }}</td>
                            <td style="color:#ff4d4d; font-weight:700;">₹{{ number_format($w->amount, 2) }}</td>
                            <td><span class="badge bg-secondary">{{ strtoupper($w->method) }}</span></td>
                            <td style="color:#c0c0e0; font-family:monospace; font-size:.85rem;">{{ $w->utr_number ?? '—' }}</td>
                            <td><span class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span></td>
                            <td style="color:#7777aa; font-size:.85rem;">{{ $w->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="font-size:2.5rem;">🏦</div>
                                <div class="text-muted mt-2">No withdrawals yet</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $withdrawals->links() }}</div>
    </div>

    {{-- Live Pool --}}
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="width:10px;height:10px;background:#4cdf80;border-radius:50%;display:inline-block;animation:pulse 1.5s infinite;"></span>
                Live Withdrawal Pool
            </div>
            <div class="card-body">
                @forelse($pool as $p)
                <div class="pool-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="color:#f0a500; font-weight:700; font-size:1.1rem;">₹{{ number_format($p->amount, 2) }}</span>
                        <span class="badge badge-pending">Pending</span>
                    </div>
                    <div style="color:#7777aa; font-size:.8rem; margin-top:4px;">
                        <i class="bi bi-credit-card me-1"></i>{{ strtoupper($p->method) }}
                        &nbsp;•&nbsp;
                        <i class="bi bi-clock me-1"></i>{{ $p->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <div style="font-size:2rem;">✅</div>
                    <div class="text-muted mt-2" style="font-size:.9rem;">Pool is empty</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection
@section('scripts')
<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>
@endsection
