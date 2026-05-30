@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- Deposit Required Banner --}}
@php $hasDeposit = auth()->user()->deposits()->where('status','approved')->exists(); @endphp
@unless($hasDeposit)
<div class="alert mb-4" style="background:#1a0d00; border:1px solid #f0a500; color:#f0a500; border-radius:12px; padding:14px 16px;">
    <div class="d-flex align-items-start gap-2">
        <span style="font-size:1.5rem;flex-shrink:0;">🔒</span>
        <div class="flex-grow-1" style="min-width:0;">
            <div style="font-weight:700; font-size:.95rem;">Your Dashboard is Locked</div>
            <div style="font-size:.82rem; color:#c0a060; margin-top:3px;">Make your first deposit to unlock full access.</div>
        </div>
        <a href="{{ route('deposit.create') }}" class="btn btn-primary btn-sm flex-shrink-0">Deposit Now</a>
    </div>
</div>
@endunless
{{-- USDT Rate Bar --}}
<div class="d-flex align-items-center gap-3 mb-3 px-3 py-2" style="background:linear-gradient(90deg,#0a1a12,#0d1f18); border:1px solid #26a17b55; border-radius:12px;">
    <div style="width:34px;height:34px;background:#26a17b;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:900;color:#fff;font-size:1rem;">₮</div>
    <div>
        <div style="color:#5a8a70;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Live USDT Rate</div>
        <div style="font-size:1.05rem;font-weight:800;"><span style="color:#26a17b;">1 USDT</span> <span style="color:#5a5a80;">=</span> <span style="color:#f0a500;">₹{{ number_format($usdtRate, 2) }}</span></div>
    </div>
    <div class="ms-auto text-end">
        <div style="color:#5a5a80;font-size:.72rem;"></div>
        <div style="color:#26a17b;font-size:.78rem;font-weight:600;">● Live</div>
    </div>
</div>

{{-- Wallet Cards --}}
@php
    $totalBalance = $user->wallet->main_balance + $user->wallet->earnings_balance;
    $totalUsdt    = $usdtRate > 0 ? $totalBalance / $usdtRate : 0;
@endphp

{{-- Total Balance Card --}}
<div class="mb-3" style="background:linear-gradient(135deg,#0d1f18 0%,#13132b 100%);border:1px solid #26a17b44;border-radius:16px;padding:16px 18px;">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
        <div style="min-width:0;">
            <div style="color:#5a8a70;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Total Balance</div>
            <div style="font-size:1.7rem;font-weight:900;color:#f0a500;line-height:1.1;word-break:break-all;">₹{{ number_format($totalBalance, 2) }}</div>
            <div style="color:#26a17b;font-size:.85rem;font-weight:700;margin-top:3px;">≈ {{ number_format($totalUsdt, 4) }} <span style="color:#5a8a70;font-weight:500;">USDT</span></div>
        </div>
        <div class="text-end flex-shrink-0">
            <div style="color:#5a5a80;font-size:.72rem;">Main + Earnings</div>
            <div style="font-size:.82rem;color:#8888aa;margin-top:4px;">Pending: <span style="color:#ff9800;">₹{{ number_format($user->wallet->pending_balance, 2) }}</span></div>
            <div style="font-size:.75rem;color:#5a8a70;">≈ {{ number_format($usdtRate > 0 ? $user->wallet->pending_balance / $usdtRate : 0, 4) }} USDT</div>
        </div>
    </div>
</div>

{{-- 3 Wallet Cards --}}
<div class="row g-3 mb-4">
    <div class="col-4">
        <div style="background:#13132b;border:1px solid #2a2a50;border-radius:14px;padding:12px 10px;">
            <div style="color:#8888aa;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:5px;">💰 Main</div>
            <div style="font-size:.95rem;font-weight:800;color:#f0a500;word-break:break-all;">₹{{ number_format($user->wallet->main_balance, 0) }}</div>
            <div style="color:#26a17b;font-size:.65rem;margin-top:3px;font-weight:600;">{{ number_format($usdtRate > 0 ? $user->wallet->main_balance / $usdtRate : 0, 2) }} <span style="color:#3a6a50;font-weight:400;">USDT</span></div>
        </div>
    </div>
    <div class="col-4">
        <div style="background:#13132b;border:1px solid #2a2a50;border-radius:14px;padding:12px 10px;">
            <div style="color:#8888aa;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:5px;">📈 Earn</div>
            <div style="font-size:.95rem;font-weight:800;color:#4cdf80;word-break:break-all;">₹{{ number_format($user->wallet->earnings_balance, 0) }}</div>
            <div style="color:#26a17b;font-size:.65rem;margin-top:3px;font-weight:600;">{{ number_format($usdtRate > 0 ? $user->wallet->earnings_balance / $usdtRate : 0, 2) }} <span style="color:#3a6a50;font-weight:400;">USDT</span></div>
        </div>
    </div>
    <div class="col-4">
        <div style="background:#13132b;border:1px solid #2a2a50;border-radius:14px;padding:12px 10px;">
            <div style="color:#8888aa;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.3px;margin-bottom:5px;">⏳ Pend</div>
            <div style="font-size:.95rem;font-weight:800;color:#ff9800;word-break:break-all;">₹{{ number_format($user->wallet->pending_balance, 0) }}</div>
            <div style="color:#26a17b;font-size:.65rem;margin-top:3px;font-weight:600;">{{ number_format($usdtRate > 0 ? $user->wallet->pending_balance / $usdtRate : 0, 2) }} <span style="color:#3a6a50;font-weight:400;">USDT</span></div>
        </div>
    </div>
</div>

{{-- Performance Bonus --}}
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
            <span style="font-size:.95rem;">🏆 Performance Commission</span>
            <span class="text-muted" style="font-size:.8rem;">Target: <span class="text-gold">₹{{ number_format($performanceTarget, 0) }}</span></span>
        </div>
    </div>
    <div class="card-body">
        @php $pct = $performanceTarget > 0 ? min(100, ($todayVolume / $performanceTarget) * 100) : 0; @endphp
        <div class="d-flex justify-content-between flex-wrap gap-1 mb-2">
            <span style="color:#c0c0e0; font-size:.85rem;">Today's Volume</span>
            <span class="text-gold fw-bold" style="font-size:.85rem;">₹{{ number_format($todayVolume, 2) }} <span class="text-muted">/ ₹{{ number_format($performanceTarget, 0) }}</span></span>
        </div>
        <div class="progress mb-2" style="height:12px;">
            <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $pct >= 100 ? '#4cdf80' : '#f0a500' }}; border-radius:10px; transition:width .5s;"></div>
        </div>
        @if($pct >= 100)
            <div class="text-green small"><i class="bi bi-check-circle-fill me-1"></i>Target achieved! Bonus credited to Earnings Wallet.</div>
        @else
            <div style="color:#8888aa; font-size:.85rem;"><i class="bi bi-info-circle me-1"></i>₹{{ number_format($performanceTarget - $todayVolume, 2) }} more needed to unlock performance bonus.</div>
        @endif
    </div>
</div>

{{-- Community Links --}}
<div class="row g-3 mb-4">
    <div class="col-6">
        <a href="https://chat.whatsapp.com/YOUR_WHATSAPP_GROUP_LINK" target="_blank" class="card p-2 text-decoration-none d-flex flex-column align-items-center justify-content-center text-center" style="min-height:90px;">
            <div style="width:40px; height:40px; background:#25D366; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-bottom:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </div>
            <div style="color:#25D366; font-weight:700; font-size:.82rem;">WhatsApp</div>
            <div style="color:#7777aa; font-size:.72rem;">Join Group</div>
        </a>
    </div>
    <div class="col-6">
        <a href="https://t.me/YOUR_TELEGRAM_GROUP_LINK" target="_blank" class="card p-2 text-decoration-none d-flex flex-column align-items-center justify-content-center text-center" style="min-height:90px;">
            <div style="width:40px; height:40px; background:#0088cc; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-bottom:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
            </div>
            <div style="color:#0088cc; font-weight:700; font-size:.82rem;">Telegram</div>
            <div style="color:#7777aa; font-size:.72rem;">Join Channel</div>
        </a>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <a href="{{ route('referral') }}" class="card p-3 text-decoration-none d-block">
            <div class="d-flex align-items-center gap-3">
                <div style="font-size:2rem;">🔗</div>
                <div class="flex-grow-1">
                    <div style="color:#8888aa; font-size:.8rem; font-weight:600; text-transform:uppercase;">Your Referral Code</div>
                    <div style="font-size:1.4rem; font-weight:800; color:#f0a500; letter-spacing:4px; font-family:monospace;">{{ $user->referral_code }}</div>
                    <div style="color:#4cdf80; font-size:.8rem; margin-top:2px;">{{ $referralCount }} referrals • Tap to share →</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('deposit.create') }}" class="card p-3 text-decoration-none d-flex flex-column align-items-center justify-content-center" style="min-height:90px;">
            <div style="font-size:1.8rem;">💰</div>
            <div class="text-gold fw-bold mt-1">Deposit</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('withdrawal.create') }}" class="card p-3 text-decoration-none d-flex flex-column align-items-center justify-content-center" style="min-height:90px;">
            <div style="font-size:1.8rem;">🏦</div>
            <div class="text-gold fw-bold mt-1">Withdraw</div>
        </a>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📋 Recent Transactions</span>
        <a href="{{ route('reports') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Wallet</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $tx)
                <tr>
                    <td><span class="badge bg-secondary">{{ ucfirst($tx->type) }}</span></td>
                    <td style="color:#c0c0e0;">{{ ucfirst($tx->wallet) }}</td>
                    <td class="{{ $tx->direction === 'credit' ? 'text-green' : 'text-red' }}" style="font-weight:600;">
                        {{ $tx->direction === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                        @if($tx->type === 'deposit' && $tx->deposit && $tx->deposit->payment_type === 'usdt')
                        <div style="color:#26a17b;font-size:.75rem;font-weight:500;">{{ number_format($tx->deposit->usdt_amount, 4) }} USDT</div>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td style="color:#8888aa; font-size:.85rem;">{{ $tx->created_at->format('d M, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="font-size:2rem;">📭</div>
                        <div class="text-muted mt-2">No transactions yet</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection
