@extends('layouts.admin')
@section('title', 'Withdrawal Receipt')
@section('content')

<div class="card" style="max-width:700px; margin:30px auto;">
    <div class="card-body p-4">
        
        {{-- Header --}}
        <div style="text-align:center; border-bottom:2px solid #3a3a60; padding-bottom:20px; margin-bottom:25px;">
            <div style="font-size:1.8rem; font-weight:700; color:#f0f0f0; margin-bottom:4px;">WITHDRAWAL RECEIPT</div>
            <div style="color:#7777aa; font-size:.9rem;">Transaction ID: #{{ $withdrawal->id }}</div>
        </div>

        {{-- User Info --}}
        <div style="background:#1a1a38; border-radius:10px; padding:16px; margin-bottom:20px;">
            <div class="d-flex justify-content-between mb-2">
                <span style="color:#7777aa; font-size:.85rem;">User Name</span>
                <span style="color:#f0f0f0; font-weight:600;">{{ $withdrawal->user->name }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span style="color:#7777aa; font-size:.85rem;">Mobile</span>
                <span style="color:#c0c0e0; font-family:monospace;">{{ $withdrawal->user->mobile }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span style="color:#7777aa; font-size:.85rem;">User ID</span>
                <span style="color:#c0c0e0; font-family:monospace;">{{ $withdrawal->user->id }}</span>
            </div>
        </div>

        {{-- Transaction Details --}}
        <div style="background:#1a1a38; border-radius:10px; padding:16px; margin-bottom:20px;">
            <div style="color:#7777aa; font-size:.85rem; margin-bottom:12px; font-weight:600;">TRANSACTION DETAILS</div>
            
            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">Amount</span>
                <span style="color:#ff4d4d; font-weight:700; font-size:1.1rem;">₹{{ number_format($withdrawal->amount, 2) }}</span>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">Method</span>
                <span style="color:#f0f0f0; font-weight:600;">{{ strtoupper($withdrawal->method) }}</span>
            </div>

            @if($withdrawal->method === 'upi')
            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">UPI ID</span>
                <span style="color:#c0c0e0; font-family:monospace; font-size:.9rem;">{{ $withdrawal->upi_id }}</span>
            </div>
            @elseif($withdrawal->method === 'bank')
            <div class="d-flex justify-content-between mb-2">
                <span style="color:#7777aa; font-size:.85rem;">Account No.</span>
                <span style="color:#c0c0e0; font-family:monospace; font-size:.9rem;">{{ $withdrawal->bank_account }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">IFSC Code</span>
                <span style="color:#c0c0e0; font-family:monospace; font-size:.9rem;">{{ $withdrawal->bank_ifsc }}</span>
            </div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">Status</span>
                <span class="badge badge-{{ $withdrawal->status }}">{{ ucfirst($withdrawal->status) }}</span>
            </div>

            @if($withdrawal->utr_number)
            <div class="d-flex justify-content-between">
                <span style="color:#7777aa; font-size:.85rem;">UTR / Ref. No.</span>
                <span style="color:#4cdf80; font-family:monospace; font-weight:600;">{{ $withdrawal->utr_number }}</span>
            </div>
            @endif
        </div>

        {{-- User Statistics --}}
        <div style="background:#1a1a38; border-radius:10px; padding:16px; margin-bottom:20px;">
            <div style="color:#7777aa; font-size:.85rem; margin-bottom:12px; font-weight:600;">YOUR WITHDRAWAL SUMMARY</div>
            
            <div class="d-flex justify-content-between mb-3">
                <span style="color:#7777aa; font-size:.85rem;">Total Withdrawals</span>
                <span style="color:#f0f0f0; font-weight:700; font-size:1.1rem;">{{ $totalWithdrawals }}</span>
            </div>

            <div class="d-flex justify-content-between">
                <span style="color:#7777aa; font-size:.85rem;">Total Amount Withdrawn</span>
                <span style="color:#4cdf80; font-weight:700; font-size:1.1rem;">₹{{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>

        {{-- Timestamps --}}
        <div style="background:#1a1a38; border-radius:10px; padding:16px; margin-bottom:25px;">
            <div class="d-flex justify-content-between mb-2">
                <span style="color:#7777aa; font-size:.85rem;">Requested</span>
                <span style="color:#c0c0e0; font-size:.85rem;">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</span>
            </div>
            @if($withdrawal->processed_at)
            <div class="d-flex justify-content-between">
                <span style="color:#7777aa; font-size:.85rem;">Completed</span>
                <span style="color:#4cdf80; font-size:.85rem;">{{ $withdrawal->processed_at->format('d M Y, h:i A') }}</span>
            </div>
            @endif
        </div>

        {{-- Print Button --}}
        <div style="text-align:center; padding-top:16px; border-top:1px solid #3a3a60;">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-2"></i>Print Receipt
            </button>
            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

    </div>
</div>

@endsection
@section('scripts')
<style>
    @media print {
        body { background: #fff; }
        .card { box-shadow: none; border: 1px solid #ddd; }
        .btn { display: none; }
        [style*="background:#1a1a38"] { background: #f9f9f9 !important; border: 1px solid #e0e0e0 !important; }
    }
</style>
@endsection
