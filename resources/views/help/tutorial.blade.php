@extends('layouts.app')
@section('title', 'Tutorial')
@section('content')

<div style="text-align:center; margin-bottom:28px;">
    <div style="font-size:3rem;">📖</div>
    <div style="font-size:1.3rem; font-weight:700; color:#f0f0f0; margin-top:8px;">How to Use FastPayz</div>
    <div style="color:#7777aa; font-size:.9rem; margin-top:4px;">Step-by-step guide for all features</div>
</div>

<div class="row g-4">

    {{-- Tutorial 1: Register --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#f0a500; color:#000; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">1</span>
                📱 Register Kaise Kare
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-phone', 'text'=>'Register page pe jao aur apna 10-digit mobile number enter karo'],
                        ['icon'=>'bi-shield-check', 'text'=>'OTP aayega mobile pe - woh enter karo (Dev mode mein screen pe dikhega)'],
                        ['icon'=>'bi-person-plus', 'text'=>'Apna naam aur password set karo'],
                        ['icon'=>'bi-gift', 'text'=>'Agar kisi ne referral code diya hai toh woh enter karo (optional)'],
                        ['icon'=>'bi-check-circle', 'text'=>'Account ban gaya! Dashboard pe redirect ho jaoge'],
                    ]; @endphp
                    @foreach($steps as $i => $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#f0a500;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tutorial 2: Deposit --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#4cdf80; color:#000; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">2</span>
                💰 Deposit Kaise Kare
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-arrow-down-circle', 'text'=>'Sidebar mein Deposit → New Deposit pe click karo'],
                        ['icon'=>'bi-qr-code', 'text'=>'Page pe admin ka UPI ID aur QR code dikhega'],
                        ['icon'=>'bi-phone', 'text'=>'Apne payment app (GPay/PhonePe/Paytm) se payment karo'],
                        ['icon'=>'bi-hash', 'text'=>'Payment app mein transaction history se 12-digit UTR copy karo'],
                        ['icon'=>'bi-image', 'text'=>'Amount, UTR number aur payment screenshot form mein bharo'],
                        ['icon'=>'bi-clock', 'text'=>'Submit karo - Admin 30 min mein verify karke wallet credit karega'],
                    ]; @endphp
                    @foreach($steps as $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#4cdf80;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tutorial 3: Withdrawal --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#ff4d4d; color:#fff; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">3</span>
                🏦 Withdrawal Kaise Kare
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-arrow-up-circle', 'text'=>'Sidebar mein Withdrawal → New Withdrawal pe click karo'],
                        ['icon'=>'bi-currency-rupee', 'text'=>'Amount enter karo (minimum ₹100, available balance se kam)'],
                        ['icon'=>'bi-credit-card', 'text'=>'UPI ya Bank Transfer select karo'],
                        ['icon'=>'bi-person-vcard', 'text'=>'Apna UPI ID ya Bank details enter karo'],
                        ['icon'=>'bi-send', 'text'=>'Submit karo - request Live Pool mein chali jayegi'],
                        ['icon'=>'bi-check2-all', 'text'=>'Admin process karega aur UTR ke saath complete mark karega'],
                    ]; @endphp
                    @foreach($steps as $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#ff4d4d;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tutorial 4: Referral --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#4db8ff; color:#000; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">4</span>
                🔗 Referral Se Earn Kaise Kare
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-people', 'text'=>'Sidebar mein Referral pe click karo'],
                        ['icon'=>'bi-link-45deg', 'text'=>'Apna referral link copy karo ya WhatsApp/Telegram se share karo'],
                        ['icon'=>'bi-person-plus', 'text'=>'Dost us link se register karta hai - code automatically fill hota hai'],
                        ['icon'=>'bi-arrow-down-circle', 'text'=>'Jab wo deposit karta hai - aapko 1% commission milta hai'],
                        ['icon'=>'bi-arrow-up-circle', 'text'=>'Jab wo withdrawal karta hai - aapko 0.5% commission milta hai'],
                        ['icon'=>'bi-wallet2', 'text'=>'Commission seedha Earnings Wallet mein credit hota hai'],
                    ]; @endphp
                    @foreach($steps as $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#4db8ff;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tutorial 5: Reports --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#9b59b6; color:#fff; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">5</span>
                📊 Reports Kaise Dekhe
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-bar-chart', 'text'=>'Sidebar mein Reports pe click karo'],
                        ['icon'=>'bi-graph-up', 'text'=>'Total deposited, withdrawn aur commission earned dikhega'],
                        ['icon'=>'bi-list-ul', 'text'=>'Neeche poori transaction history milegi'],
                        ['icon'=>'bi-funnel', 'text'=>'Har transaction ka type, wallet, amount aur status dikhega'],
                    ]; @endphp
                    @foreach($steps as $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#9b59b6;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tutorial 6: Settings --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span style="background:#ff9800; color:#000; border-radius:50%; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; flex-shrink:0;">6</span>
                ⚙️ Settings Kaise Use Kare
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @php $steps = [
                        ['icon'=>'bi-gear', 'text'=>'Sidebar mein Settings pe click karo'],
                        ['icon'=>'bi-person', 'text'=>'Naam aur payment details (UPI/Bank) update kar sakte ho'],
                        ['icon'=>'bi-lock', 'text'=>'Password change karne ke liye current password zaroori hai'],
                        ['icon'=>'bi-key', 'text'=>'6-digit Security PIN set karo transactions ke liye'],
                        ['icon'=>'bi-bank', 'text'=>'Bank details save karo taaki withdrawal mein auto-fill ho'],
                    ]; @endphp
                    @foreach($steps as $s)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="background:#1a1a38; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $s['icon'] }}" style="color:#ff9800;"></i>
                        </div>
                        <div style="color:#c0c0e0; font-size:.9rem; padding-top:6px;">{{ $s['text'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Still need help --}}
<div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:12px; padding:24px; text-align:center; margin-top:24px;">
    <div style="font-size:1.5rem; margin-bottom:8px;">🤝</div>
    <div style="color:#f0f0f0; font-weight:600; margin-bottom:4px;">Abhi bhi koi problem hai?</div>
    <div style="color:#7777aa; font-size:.9rem; margin-bottom:16px;">Hamari support team 24/7 available hai</div>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('support.create') }}" class="btn btn-primary">
            <i class="bi bi-headset me-2"></i>Support Ticket
        </a>
        <a href="{{ route('faq') }}" class="btn btn-outline-secondary">
            <i class="bi bi-patch-question me-2"></i>FAQ Dekho
        </a>
    </div>
</div>

@endsection
