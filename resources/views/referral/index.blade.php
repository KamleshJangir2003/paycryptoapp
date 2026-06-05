@extends('layouts.app')
@section('title', 'Referral Program')
@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">👥 Total Referrals</div>
            <div class="stat-value blue">{{ $referrals->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">💎 Total Earned</div>
            <div class="stat-value green">₹{{ number_format($totalEarned, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">📅 This Month</div>
            <div class="stat-value" style="color:#f0a500;">₹{{ number_format($thisMonthEarned, 2) }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-center">
            <div class="stat-label">💰 In Earnings Wallet</div>
            <div class="stat-value green">₹{{ number_format($user->wallet->earnings_balance, 2) }}</div>
        </div>
    </div>
</div>

{{-- Referral Link Box --}}
<div class="card mb-4">
    <div class="card-header">🔗 Your Referral Link</div>
    <div class="card-body">

        {{-- Code --}}
        <div class="text-center mb-4">
            <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Your Referral Code</div>
            <div style="font-size:2.2rem; font-weight:900; color:#f0a500; letter-spacing:8px; font-family:monospace;">{{ $user->referral_code }}</div>
        </div>

        {{-- Link --}}
        <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:16px;">
            <div style="color:#7777aa; font-size:.78rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Referral Link</div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div id="refLink" style="color:#4db8ff; font-size:.88rem; word-break:break-all; flex:1; font-family:monospace;">{{ $referralLink }}</div>
                <button class="btn btn-sm btn-primary" onclick="copyLink()" id="copyBtn">
                    <i class="bi bi-copy me-1"></i>Copy Link
                </button>
            </div>
        </div>

        {{-- Share Buttons --}}
        <div style="color:#8888aa; font-size:.82rem; font-weight:600; text-transform:uppercase; margin-bottom:10px;">Share via</div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="https://wa.me/?text={{ urlencode('Join FastPayz and earn money! Use my referral code: '.$user->referral_code.' Register here: '.$referralLink) }}"
                target="_blank" class="btn btn-sm" style="background:#25D366; color:#fff; font-weight:600;">
                <i class="bi bi-whatsapp me-1"></i>WhatsApp
            </a>
            <a href="https://t.me/share/url?url={{ urlencode($referralLink) }}&text={{ urlencode('Join FastPayz! Use my referral code: '.$user->referral_code) }}"
                target="_blank" class="btn btn-sm" style="background:#0088cc; color:#fff; font-weight:600;">
                <i class="bi bi-telegram me-1"></i>Telegram
            </a>
            <button class="btn btn-sm btn-outline-secondary" onclick="shareNative()">
                <i class="bi bi-share me-1"></i>Share
            </button>
        </div>

    </div>
</div>

{{-- How it works --}}
<div class="card mb-4">
    <div class="card-header">💡 How Referral Works</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:16px; text-align:center;">
                    <div style="font-size:2rem; margin-bottom:8px;">🔗</div>
                    <div style="color:#f0f0f0; font-weight:600; margin-bottom:4px;">Step 1: Share</div>
                    <div style="color:#7777aa; font-size:.85rem;">Share your referral link or code with friends</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:16px; text-align:center;">
                    <div style="font-size:2rem; margin-bottom:8px;">📝</div>
                    <div style="color:#f0f0f0; font-weight:600; margin-bottom:4px;">Step 2: Friend Registers</div>
                    <div style="color:#7777aa; font-size:.85rem;">They register using your code and start transacting</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:16px; text-align:center;">
                    <div style="font-size:2rem; margin-bottom:8px;">💰</div>
                    <div style="color:#f0f0f0; font-weight:600; margin-bottom:4px;">Step 3: You Earn</div>
                    <div style="color:#7777aa; font-size:.85rem;">
                        <span style="color:#f0a500; font-weight:700;">₹1000</span> on registration<br>
                        <span style="color:#4cdf80; font-weight:700;">1%</span> on their deposits<br>
                        <span style="color:#4cdf80; font-weight:700;">0.5%</span> on their withdrawals
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Community Links --}}
@if($setting->whatsapp_link || $setting->telegram_link)
<div class="card mb-4">
    <div class="card-header">📣 Join Our Community</div>
    <div class="card-body">
        <div style="color:#8888aa; font-size:.85rem; margin-bottom:14px;">Updates, announcements aur support ke liye join karo:</div>
        <div class="d-flex gap-3 flex-wrap">
            @if($setting->whatsapp_link)
            <a href="{{ $setting->whatsapp_link }}" target="_blank" class="btn" style="background:#25D366; color:#fff; font-weight:700; font-size:.9rem; padding:10px 22px;">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp Channel
            </a>
            @endif
            @if($setting->telegram_link)
            <a href="{{ $setting->telegram_link }}" target="_blank" class="btn" style="background:#0088cc; color:#fff; font-weight:700; font-size:.9rem; padding:10px 22px;">
                <i class="bi bi-telegram me-2"></i>Telegram Channel
            </a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Referred Users List --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>👥 People You Referred</span>
        <span style="color:#7777aa; font-size:.85rem;">{{ $referrals->count() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Joined</th>
                    <th>Deposits Done</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($referrals as $r)
                <tr>
                    <td style="color:#f0f0f0; font-weight:500;">{{ $r->name }}</td>
                    <td style="color:#c0c0e0; font-family:monospace;">{{ substr($r->mobile, 0, 5) }}*****</td>
                    <td style="color:#7777aa; font-size:.85rem;">{{ $r->created_at->format('d M Y') }}</td>
                    <td style="color:#f0a500; font-weight:600;">{{ $r->total_deposits ?? 0 }}</td>
                    <td>
                        @if($r->is_active)
                        <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">Active</span>
                        @else
                        <span class="badge" style="background:#2a0d0d; color:#ff4d4d; border:1px solid #ff4d4d;">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="font-size:2.5rem;">👥</div>
                        <div class="text-muted mt-2">No referrals yet</div>
                        <div style="color:#5a5a80; font-size:.85rem; margin-top:4px;">Share your link above to start earning</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- Commission History --}}
<div class="card">
    <div class="card-header">💎 Commission History</div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Type</th>
                    <th>Transaction</th>
                    <th>Rate</th>
                    <th>Commission</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $c)
                <tr>
                    <td style="color:#f0f0f0;">{{ $c->fromUser?->name ?? 'System' }}</td>
                    <td>
                        <span class="badge" style="background:{{ $c->type === 'deposit' ? '#0d2a1a' : '#1a1a0d' }}; color:{{ $c->type === 'deposit' ? '#4cdf80' : '#f0a500' }}; border:1px solid {{ $c->type === 'deposit' ? '#4cdf80' : '#f0a500' }};">
                            {{ ucfirst($c->type) }}
                        </span>
                    </td>
                    <td style="color:#c0c0e0;">₹{{ number_format($c->transaction_amount, 2) }}</td>
                    <td style="color:#7777aa;">{{ $c->commission_rate }}%</td>
                    <td style="color:#4cdf80; font-weight:700;">+₹{{ number_format($c->commission_amount, 2) }}</td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $c->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div style="font-size:2.5rem;">💎</div>
                        <div class="text-muted mt-2">No commissions yet</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText('{{ $referralLink }}');
    const btn = document.getElementById('copyBtn');
    btn.innerHTML = '<i class="bi bi-check me-1"></i>Copied!';
    btn.style.background = '#4cdf80';
    btn.style.borderColor = '#4cdf80';
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-copy me-1"></i>Copy Link';
        btn.style.background = '';
        btn.style.borderColor = '';
    }, 2000);
}

function shareNative() {
    if (navigator.share) {
        navigator.share({
            title: 'Join FastPayz',
            text: 'Join FastPayz and earn money! Use my referral code: {{ $user->referral_code }}',
            url: '{{ $referralLink }}'
        });
    } else {
        copyLink();
    }
}
</script>
@endsection
