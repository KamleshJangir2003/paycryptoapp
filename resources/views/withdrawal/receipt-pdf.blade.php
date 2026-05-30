<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Withdrawal Receipt</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; background: #fff; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .header { text-align: center; border-bottom: 3px solid #f0a500; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #000; margin-bottom: 5px; }
        .header p { color: #666; font-size: 14px; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 13px; font-weight: bold; color: #fff; background: #333; padding: 8px 12px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .info-box { background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .info-label { color: #666; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .info-value { color: #000; font-size: 14px; font-weight: 500; }
        .amount { color: #d9534f; font-size: 16px; font-weight: bold; }
        .status { display: inline-block; padding: 4px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .utr { color: #28a745; font-family: monospace; font-weight: bold; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e0e0e0; text-align: center; color: #666; font-size: 11px; }
        .divider { height: 1px; background: #e0e0e0; margin: 20px 0; }
    </style>
</head>
<body>

<div class="container">
    {{-- Header --}}
    <div class="header">
        <h1>WITHDRAWAL RECEIPT</h1>
        <p>Transaction ID: #{{ $withdrawal->id }}</p>
    </div>

    {{-- User Information --}}
    <div class="section">
        <div class="section-title">Your Information</div>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ $withdrawal->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Mobile</span>
                <span class="info-value">{{ $withdrawal->user->mobile }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">User ID</span>
                <span class="info-value">{{ $withdrawal->user->id }}</span>
            </div>
        </div>
    </div>

    {{-- Transaction Details --}}
    <div class="section">
        <div class="section-title">Transaction Details</div>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Amount</span>
                <span class="info-value amount">₹{{ number_format($withdrawal->amount, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Method</span>
                <span class="info-value">{{ strtoupper($withdrawal->method) }}</span>
            </div>
            
            @if($withdrawal->method === 'upi')
            <div class="info-row">
                <span class="info-label">UPI ID</span>
                <span class="info-value" style="font-family: monospace;">{{ $withdrawal->upi_id }}</span>
            </div>
            @elseif($withdrawal->method === 'bank')
            <div class="info-row">
                <span class="info-label">Account Number</span>
                <span class="info-value" style="font-family: monospace;">{{ $withdrawal->bank_account }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">IFSC Code</span>
                <span class="info-value" style="font-family: monospace;">{{ $withdrawal->bank_ifsc }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Bank Name</span>
                <span class="info-value">{{ $withdrawal->bank_name }}</span>
            </div>
            @endif

            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="status status-{{ $withdrawal->status }}">{{ ucfirst($withdrawal->status) }}</span>
            </div>

            @if($withdrawal->utr_number)
            <div class="info-row">
                <span class="info-label">UTR / Reference No.</span>
                <span class="info-value utr">{{ $withdrawal->utr_number }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Withdrawal Summary --}}
    <div class="section">
        <div class="section-title">Your Withdrawal Summary</div>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Total Withdrawals</span>
                <span class="info-value">{{ $totalWithdrawals }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Amount Withdrawn</span>
                <span class="info-value amount">₹{{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Timestamps --}}
    <div class="section">
        <div class="section-title">Timeline</div>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Requested</span>
                <span class="info-value">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</span>
            </div>
            @if($withdrawal->processed_at)
            <div class="info-row">
                <span class="info-label">Completed</span>
                <span class="info-value" style="color: #28a745;">{{ $withdrawal->processed_at->format('d M Y, h:i A') }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="divider"></div>

    {{-- Footer --}}
    <div class="footer">
        <p>This is your official withdrawal receipt.</p>
        <p>Please keep this receipt for your records.</p>
        <p style="margin-top: 10px;">Generated on: {{ now()->format('d M Y, h:i A') }}</p>
    </div>
</div>

</body>
</html>
