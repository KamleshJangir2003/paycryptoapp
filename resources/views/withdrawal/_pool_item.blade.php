<div class="pi-wrap">
    @php $piConf = $p->partialTransactions->where('status','confirmed')->sum('amount'); @endphp
    <div class="pi-top">
        <span class="pi-amount">₹{{ number_format($p->amount - $piConf, 2) }} <span style="font-size:.65rem;color:#555588;font-weight:400;">/ ₹{{ number_format($p->amount,2) }}</span></span>
        @if($p->status === 'pending')
            <span class="pi-badge-p"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
        @else
            <span class="pi-badge-r"><i class="bi bi-arrow-repeat me-1"></i>Processing</span>
        @endif
    </div>
    <div class="pi-meta">
        <i class="bi bi-credit-card"></i>{{ strtoupper($p->method) }}
        &nbsp;·&nbsp;
        <i class="bi bi-clock"></i>{{ $p->created_at->diffForHumans() }}
    </div>

    @if($p->partialTransactions->count())
    <div class="pi-partials">
        @foreach($p->partialTransactions->sortBy('created_at') as $pt)
        <div class="pi-pt {{ $pt->status === 'confirmed' ? 'ok' : '' }}">
            <div class="pi-pt-left">
                <span class="pi-pt-amt">₹{{ number_format($pt->amount, 2) }}</span>
                @if($pt->utr_number)
                <span class="pi-pt-utr">UTR: {{ $pt->utr_number }}</span>
                @endif
                <span class="pi-pt-time">{{ $pt->created_at->format('d M, h:i A') }}</span>
            </div>
            @if($pt->status === 'confirmed')
                <span class="pi-pt-status-ok"><i class="bi bi-check-circle-fill"></i> Done</span>
            @else
                <span class="pi-pt-status-wait"><i class="bi bi-hourglass-split"></i> Wait</span>
            @endif
        </div>
        @endforeach

        @php
            $conf = $p->partialTransactions->where('status','confirmed')->sum('amount');
            $pct  = $p->amount > 0 ? min(100, round($conf / $p->amount * 100)) : 0;
        @endphp
        <div class="pi-progress">
            <div class="pi-progress-label">
                <span>₹{{ number_format($conf,2) }} received</span>
                <span style="color:#ff9800;">₹{{ number_format($p->amount - $conf, 2) }} pending</span>
            </div>
            <div class="pi-progress-bar"><div style="width:{{ $pct }}%;"></div></div>
        </div>
    </div>
    @endif
</div>
