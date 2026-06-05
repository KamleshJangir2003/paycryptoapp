@extends('layouts.app')
@section('title', 'Withdrawal')
@section('content')

<div class="wd-wrap">

    {{-- Top bar --}}
    <div class="wd-topbar">
        <span class="wd-sub">withdrawal transactions</span>
        <a href="{{ route('withdrawal.create') }}" class="wd-btn-new">
            <i class="bi bi-plus-lg"></i> New Withdrawal
        </a>
    </div>

    <div class="wd-grid">

        {{-- ═══ LEFT: History ═══ --}}
        <div class="wd-left">
            <div class="wd-card">
                <div class="wd-card-head">
                    <i class="bi bi-clock-history me-2" style="color:#f0a500;"></i>Withdrawal History
                </div>

                @forelse($withdrawals as $w)
                <div class="wh-item {{ $w->status }}">

                    {{-- Row 1: amount + status --}}
                    @php $confirmedTotal = $w->partialTransactions->where('status','confirmed')->sum('amount'); @endphp
                    <div class="wh-row1">
                        <div class="wh-amount">
                            @if($w->status === 'completed')
                                ₹{{ number_format($w->amount, 2) }}
                            @else
                                ₹{{ number_format($w->amount - $confirmedTotal, 2) }} <span style="font-size:.7rem;color:#555588;font-weight:400;">/ ₹{{ number_format($w->amount,2) }}</span>
                            @endif
                        </div>
                        <span class="wh-badge {{ $w->status }}">
                            @if($w->status==='pending') <i class="bi bi-hourglass-split"></i> Pending
                            @elseif($w->status==='processing') <i class="bi bi-arrow-repeat spin"></i> Processing
                            @elseif($w->status==='completed') <i class="bi bi-check-circle-fill"></i> Completed
                            @else <i class="bi bi-x-circle-fill"></i> Failed
                            @endif
                        </span>
                    </div>

                    {{-- Row 2: meta --}}
                    <div class="wh-meta">
                        <span><i class="bi bi-credit-card"></i> {{ strtoupper($w->method) }}</span>
                        @if($w->utr_number)
                        <span><i class="bi bi-hash"></i> {{ $w->utr_number }}</span>
                        @endif
                        <span><i class="bi bi-calendar3"></i> {{ $w->created_at->format('d M Y') }}</span>
                        @if($w->status==='completed')
                        <a href="{{ route('withdrawal.receipt', $w) }}" target="_blank" class="wh-receipt-link"><i class="bi bi-download"></i> Receipt</a>
                        @endif
                    </div>

                    {{-- Partial transactions --}}
                    @if(in_array($w->status, ['processing','completed']) && $w->partialTransactions->count())
                    <div class="wh-partials {{ $w->status === 'completed' ? 'wh-partials-collapsed' : '' }}" id="partials-{{ $w->id }}">
                        @if($w->status === 'completed')
                        <div class="wh-partials-toggle" onclick="togglePartials({{ $w->id }})">
                            <i class="bi bi-list-ul"></i> Payment Breakdown
                            <i class="bi bi-chevron-down ms-auto" id="chevron-{{ $w->id }}"></i>
                        </div>
                        @else
                        <div class="wh-partials-label"><i class="bi bi-list-ul"></i> Payment Breakdown</div>
                        @endif
                    <div class="wh-partials-body" id="partials-body-{{ $w->id }}" style="{{ $w->status === 'completed' ? 'display:none;' : '' }}">
                        <div class="wh-partials-label"><i class="bi bi-list-ul"></i> Payment Breakdown</div>

                        @foreach($w->partialTransactions->sortBy('created_at') as $i => $pt)
                        <div class="pt-item {{ $pt->status }}">
                            <div class="pt-left">
                                <span class="pt-num">{{ $i+1 }}</span>
                                <div class="pt-info">
                                    <span class="pt-amt">₹{{ number_format($pt->amount, 2) }}</span>
                                    @if($pt->utr_number)
                                    <span class="pt-utr">UTR: {{ $pt->utr_number }}</span>
                                    @endif
                                    @if($pt->note)
                                    <span class="pt-note">{{ $pt->note }}</span>
                                    @endif
                                    <span class="pt-time">{{ $pt->created_at->format('d M, h:i A') }}</span>
                                </div>
                            </div>
                            <div class="pt-right">
                                @if($pt->proof_screenshot)
                                <a href="{{ asset('storage/'.$pt->proof_screenshot) }}" target="_blank" class="pt-img-link"><i class="bi bi-image"></i></a>
                                @endif
                                @if($pt->status === 'pending')
                                <form method="POST" action="{{ route('withdrawal.partial.confirm', $pt) }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="pt-confirm-btn">
                                        <i class="bi bi-check-lg"></i> Received ✓
                                    </button>
                                </form>
                                @else
                                <span class="pt-confirmed"><i class="bi bi-check-circle-fill"></i> Confirmed</span>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        {{-- Progress --}}
                        @php
                            $confirmedAmt = $w->partialTransactions->where('status','confirmed')->sum('amount');
                            $pct = $w->amount > 0 ? min(100, round($confirmedAmt / $w->amount * 100)) : 0;
                        @endphp
                        <div class="pt-progress-wrap">
                            <div class="pt-progress-labels">
                                <span>Received ₹{{ number_format($confirmedAmt, 2) }}</span>
                                <span style="color:#ff9800;">Pending ₹{{ number_format($w->amount - $confirmedAmt, 2) }}</span>
                            </div>
                            <div class="pt-progress-bar"><div style="width:{{ $pct }}%;"></div></div>
                        </div>

                        @if($w->status === 'completed')
                        <div class="pt-complete-banner">
                            <i class="bi bi-check-all me-1"></i>
                            Total ₹{{ number_format($w->amount, 2) }} — Withdrawal Complete
                            @if($w->utr_number) &nbsp;·&nbsp; Ref: {{ $w->utr_number }} @endif
                        </div>
                        @endif
                    </div>
                    </div>
                    @endif

                </div>
                @empty
                <div class="wd-empty">
                    <i class="bi bi-bank2"></i>
                    <p>Koi withdrawal nahi abhi tak</p>
                </div>
                @endforelse
            </div>
            <div class="mt-3">{{ $withdrawals->links() }}</div>
        </div>

        {{-- ═══ RIGHT: Live Pool ═══ --}}
        <div class="wd-right">
            <div class="wd-card" style="position:sticky; top:80px;">
                <div class="wd-card-head d-flex align-items-center gap-2">
                    <span class="live-dot"></span>
                    Live Withdrawal Pool
                    <span class="live-label ms-auto">LIVE</span>
                </div>
                <div id="live-pool-body" class="pool-scroll">
                    @forelse($pool as $p)
                        @include('withdrawal._pool_item', ['p' => $p])
                    @empty
                        <div class="pool-empty">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Pool is empty</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
<style>
/* ── Wrapper ── */
.wd-wrap { max-width:1200px; }
.wd-topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px; }
.wd-sub { color:#7777aa; font-size:.85rem; }
.wd-btn-new { background:#f0a500; color:#000; font-weight:700; font-size:.82rem; border-radius:8px; padding:7px 16px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; }
.wd-btn-new:hover { background:#d4920a; color:#000; }

/* ── Grid ── */
.wd-grid { display:grid; grid-template-columns:1fr 300px; gap:16px; align-items:start; }
@media(max-width:900px) { .wd-grid { grid-template-columns:1fr; } }

/* ── Card ── */
.wd-card { background:#13132b; border:1px solid #2a2a50; border-radius:12px; overflow:hidden; }
.wd-card-head { background:#1a1a38; border-bottom:1px solid #2a2a50; padding:11px 16px; font-size:.88rem; font-weight:600; color:#f0f0f0; }

/* ── History items ── */
.wh-item { border-bottom:1px solid #1e1e38; padding:12px 16px; transition:background .15s; }
.wh-item:last-child { border-bottom:none; }
.wh-item:hover { background:#14142e; }
.wh-row1 { display:flex; justify-content:space-between; align-items:center; margin-bottom:5px; }
.wh-amount { font-size:.98rem; font-weight:700; color:#f0a500; }
.wh-badge { font-size:.72rem; font-weight:600; padding:3px 9px; border-radius:20px; display:inline-flex; align-items:center; gap:4px; }
.wh-badge.pending   { background:#ff98001a; color:#ff9800; border:1px solid #ff980040; }
.wh-badge.processing{ background:#2196f31a; color:#4db8ff; border:1px solid #4db8ff40; }
.wh-badge.completed { background:#4cdf801a; color:#4cdf80; border:1px solid #4cdf8040; }
.wh-badge.failed    { background:#ff4d4d1a; color:#ff6b6b; border:1px solid #ff4d4d40; }
.wh-meta { display:flex; flex-wrap:wrap; gap:10px; font-size:.75rem; color:#6666aa; align-items:center; }
.wh-meta i { margin-right:3px; }
.wh-receipt-link { color:#4db8ff; font-size:.72rem; text-decoration:none; }
.wh-receipt-link:hover { color:#80d4ff; text-decoration:underline; }

/* ── Partial transactions ── */
.wh-partials { margin-top:10px; background:#0a0a1f; border-radius:8px; padding:10px; border:1px solid #1e1e38; }
.wh-partials-label { font-size:.72rem; color:#555588; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }
.pt-item { display:flex; justify-content:space-between; align-items:center; gap:8px; padding:7px 0; border-bottom:1px solid #15152e; flex-wrap:wrap; }
.pt-item:last-of-type { border-bottom:none; }
.pt-left { display:flex; align-items:center; gap:8px; }
.pt-num { width:20px; height:20px; border-radius:50%; background:#1e1e38; font-size:.68rem; color:#7777aa; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pt-item.confirmed .pt-num { background:#1a3020; color:#4cdf80; }
.pt-info { display:flex; flex-wrap:wrap; align-items:baseline; gap:5px; }
.pt-amt  { font-size:.85rem; font-weight:700; color:#f0f0f0; }
.pt-utr  { font-size:.72rem; font-family:monospace; color:#8888bb; background:#12122a; padding:1px 6px; border-radius:4px; }
.pt-note { font-size:.7rem; color:#555588; }
.pt-time { font-size:.68rem; color:#3a3a5a; }
.pt-right { display:flex; align-items:center; gap:6px; flex-shrink:0; }
.pt-img-link { color:#4cdf80; font-size:.9rem; opacity:.8; }
.pt-img-link:hover { opacity:1; }
.pt-confirm-btn { background:#4cdf8015; border:1px solid #4cdf8060; color:#4cdf80; font-size:.72rem; padding:4px 10px; border-radius:6px; cursor:pointer; white-space:nowrap; }
.pt-confirm-btn:hover { background:#4cdf8030; }
.pt-confirmed { font-size:.72rem; color:#4cdf80; display:flex; align-items:center; gap:3px; }

.pt-progress-wrap { margin-top:8px; }
.pt-progress-labels { display:flex; justify-content:space-between; font-size:.68rem; color:#444466; margin-bottom:4px; }
.pt-progress-bar { background:#1a1a30; border-radius:4px; height:4px; }
.pt-progress-bar div { background:linear-gradient(90deg,#4cdf80,#26a17b); height:4px; border-radius:4px; transition:width .5s; }
.pt-complete-banner { margin-top:8px; background:#0d1f0d; border:1px solid #4cdf8050; border-radius:6px; padding:7px 10px; font-size:.75rem; color:#4cdf80; display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
.wh-partials-toggle { font-size:.72rem; color:#4cdf80; text-transform:uppercase; letter-spacing:.5px; cursor:pointer; display:flex; align-items:center; gap:5px; padding:2px 0; }
.wh-partials-toggle:hover { color:#80ffb4; }

/* ── Empty ── */
.wd-empty { text-align:center; padding:40px 20px; color:#3a3a5a; }
.wd-empty i { font-size:2rem; display:block; margin-bottom:8px; }
.wd-empty p { font-size:.85rem; margin:0; }

/* ── Live Pool ── */
.live-dot { width:8px; height:8px; background:#4cdf80; border-radius:50%; flex-shrink:0; animation:livepulse 1.5s infinite; }
.live-label { font-size:.65rem; font-weight:700; color:#4cdf80; letter-spacing:1px; }
.pool-scroll { max-height:480px; overflow-y:auto; }
.pool-scroll::-webkit-scrollbar { width:3px; }
.pool-scroll::-webkit-scrollbar-thumb { background:#2a2a50; border-radius:4px; }

.pi-wrap { padding:10px 14px; border-bottom:1px solid #1a1a38; }
.pi-wrap:last-child { border-bottom:none; }
.pi-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:3px; }
.pi-amount { font-size:.9rem; font-weight:700; color:#f0a500; }
.pi-badge-p { font-size:.65rem; padding:2px 8px; border-radius:10px; background:#ff98001a; color:#ff9800; border:1px solid #ff980040; }
.pi-badge-r { font-size:.65rem; padding:2px 8px; border-radius:10px; background:#2196f31a; color:#4db8ff; border:1px solid #4db8ff40; }
.pi-meta { font-size:.72rem; color:#555588; }
.pi-meta i { margin-right:2px; }

.pi-partials { margin-top:7px; }
.pi-pt { display:flex; justify-content:space-between; align-items:center; padding:5px 8px; background:#0a0a1f; border-radius:5px; margin-bottom:3px; border-left:2px solid #ff9800; }
.pi-pt.ok { border-left-color:#4cdf80; }
.pi-pt-left { display:flex; flex-direction:column; }
.pi-pt-amt { font-size:.78rem; font-weight:600; color:#e0e0f0; }
.pi-pt-utr { font-size:.65rem; font-family:monospace; color:#666699; }
.pi-pt-time { font-size:.62rem; color:#333355; }
.pi-pt-status-ok   { font-size:.65rem; color:#4cdf80; }
.pi-pt-status-wait { font-size:.65rem; color:#ff9800; }

.pi-progress { margin-top:6px; }
.pi-progress-bar { background:#1a1a30; border-radius:3px; height:3px; }
.pi-progress-bar div { background:#4cdf80; height:3px; border-radius:3px; transition:width .4s; }
.pi-progress-label { display:flex; justify-content:space-between; font-size:.62rem; color:#333355; margin-bottom:2px; }

.pool-empty { display:flex; flex-direction:column; align-items:center; gap:6px; padding:32px 20px; color:#3a3a5a; font-size:.82rem; }
.pool-empty i { font-size:1.6rem; color:#4cdf8050; }

@keyframes livepulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.85)} }
@keyframes spin { from{transform:rotate(0)} to{transform:rotate(360deg)} }
.spin { display:inline-block; animation:spin 1.2s linear infinite; }
</style>
<script>
(function(){
    const body = document.getElementById('live-pool-body');
    let lastHash = '';
    function fetchPool(){
        fetch('{{ route('withdrawal.pool.live') }}',{headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(r=>r.json()).then(d=>{ if(d.hash!==lastHash){lastHash=d.hash;body.innerHTML=d.html;} })
        .catch(()=>{});
    }
    setInterval(fetchPool, 4000);
})();

function togglePartials(id) {
    const body = document.getElementById('partials-body-' + id);
    const chevron = document.getElementById('chevron-' + id);
    const hidden = body.style.display === 'none';
    body.style.display = hidden ? 'block' : 'none';
    chevron.className = hidden ? 'bi bi-chevron-up ms-auto' : 'bi bi-chevron-down ms-auto';
}
</script>
@endsection
