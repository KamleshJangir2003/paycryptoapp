@extends('layouts.app')
@section('title', 'Withdrawal Receipt')
@section('content')

<div style="max-width: 900px; margin: 0 auto; padding: 20px;">

    {{-- Print Controls --}}
    <div style="display: flex; gap: 10px; margin-bottom: 20px; justify-content: flex-end;">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-2"></i>Print Receipt
        </button>
        <a href="{{ route('withdrawal.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4" style="background: #fff; color: #333;">
            
            {{-- Header --}}
            <div style="text-align: center; border-bottom: 3px solid #f0a500; padding-bottom: 20px; margin-bottom: 30px;">
                <h1 style="font-size: 28px; color: #000; margin-bottom: 5px;">WITHDRAWAL RECEIPT</h1>
                <p style="color: #666; font-size: 14px;">Transaction ID: #{{ $withdrawal->id }}</p>
            </div>

            {{-- User Information --}}
            <div style="margin-bottom: 25px;">
                <div style="font-size: 13px; font-weight: bold; color: #fff; background: #333; padding: 8px 12px; margin-bottom: 12px; text-transform: uppercase;">Your Information</div>
                <div style="background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">NAME</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $withdrawal->user->name }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">MOBILE</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $withdrawal->user->mobile }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">USER ID</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $withdrawal->user->id }}</span>
                    </div>
                </div>
            </div>

            {{-- Transaction Details --}}
            <div style="margin-bottom: 25px;">
                <div style="font-size: 13px; font-weight: bold; color: #fff; background: #333; padding: 8px 12px; margin-bottom: 12px; text-transform: uppercase;">Transaction Details</div>
                <div style="background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">AMOUNT</span>
                        <span style="color: #d9534f; font-size: 16px; font-weight: bold;">₹{{ number_format($withdrawal->amount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">METHOD</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ strtoupper($withdrawal->method) }}</span>
                    </div>
                    
                    @if($withdrawal->method === 'upi')
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">UPI ID</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500; font-family: monospace;">{{ $withdrawal->upi_id }}</span>
                    </div>
                    @elseif($withdrawal->method === 'bank')
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">ACCOUNT</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500; font-family: monospace;">{{ $withdrawal->bank_account }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">IFSC</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500; font-family: monospace;">{{ $withdrawal->bank_ifsc }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">BANK</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $withdrawal->bank_name }}</span>
                    </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">STATUS</span>
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; text-transform: uppercase; background: #d4edda; color: #155724;">{{ ucfirst($withdrawal->status) }}</span>
                    </div>

                    @if($withdrawal->utr_number)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">UTR / REF NO.</span>
                        <span style="color: #28a745; font-family: monospace; font-weight: bold;">{{ $withdrawal->utr_number }}</span>
                    </div>
                    @endif

                    @if($withdrawal->proof_screenshot)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">PROOF RECEIPT</span>
                        <a href="{{ asset('storage/' . $withdrawal->proof_screenshot) }}" target="_blank" style="color: #0066cc; text-decoration: underline; font-size: 12px;">View Screenshot</a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Summary --}}
            <div style="margin-bottom: 25px;">
                <div style="font-size: 13px; font-weight: bold; color: #fff; background: #333; padding: 8px 12px; margin-bottom: 12px; text-transform: uppercase;">Your Withdrawal Summary</div>
                <div style="background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">TOTAL WITHDRAWALS</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $totalWithdrawals }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">TOTAL AMOUNT</span>
                        <span style="color: #d9534f; font-size: 16px; font-weight: bold;">₹{{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div style="margin-bottom: 25px;">
                <div style="font-size: 13px; font-weight: bold; color: #fff; background: #333; padding: 8px 12px; margin-bottom: 12px; text-transform: uppercase;">Timeline</div>
                <div style="background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">REQUESTED</span>
                        <span style="color: #000; font-size: 14px; font-weight: 500;">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @if($withdrawal->processed_at)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666; font-size: 12px; font-weight: bold;">COMPLETED</span>
                        <span style="color: #28a745; font-weight: 500;">{{ $withdrawal->processed_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div style="height: 1px; background: #e0e0e0; margin: 20px 0;"></div>

            {{-- Footer --}}
            <div style="margin-top: 40px; padding-top: 20px; text-align: center; color: #666; font-size: 11px;">
                <p>This is your official withdrawal receipt.</p>
                <p style="margin-top: 8px;">Please keep this receipt for your records.</p>
                <p style="margin-top: 8px;">Generated on: {{ now()->format('d M Y, h:i A') }}</p>
            </div>

        </div>
    </div>

</div>

@endsection
@section('scripts')
<style>
    @media print {
        body { background: #fff; }
        .btn { display: none; }
        .card { box-shadow: none; border: none; }
    }
</style>
@endsection
