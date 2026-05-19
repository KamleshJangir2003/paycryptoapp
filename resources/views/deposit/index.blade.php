@extends('layouts.app')
@section('title', 'Deposit')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div style="color:#8888aa; font-size:.9rem;">Manage your deposits</div>
    <a href="{{ route('deposit.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> New Deposit</a>
</div>

<div class="card">
    <div class="card-header">📥 Deposit History</div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>UTR Number</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deposits as $d)
                <tr>
                    <td style="color:#7777aa;">{{ $d->id }}</td>
                    <td style="color:#f0a500; font-weight:700;">₹{{ number_format($d->amount, 2) }}</td>
                    <td style="color:#c0c0e0; font-family:monospace;">{{ $d->utr_number }}</td>
                    <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.85rem;">{{ $d->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="font-size:2.5rem;">💰</div>
                        <div class="text-muted mt-2">No deposits yet</div>
                        <a href="{{ route('deposit.create') }}" class="btn btn-primary btn-sm mt-3">Make First Deposit</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $deposits->links() }}</div>
@endsection
