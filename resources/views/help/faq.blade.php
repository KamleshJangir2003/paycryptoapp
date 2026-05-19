@extends('layouts.app')
@section('title', 'FAQ')
@section('content')

<div class="row justify-content-center">
<div class="col-12 col-lg-8">

    <div style="text-align:center; margin-bottom:28px;">
        <div style="font-size:3rem;">❓</div>
        <div style="font-size:1.3rem; font-weight:700; color:#f0f0f0; margin-top:8px;">Frequently Asked Questions</div>
        <div style="color:#7777aa; font-size:.9rem; margin-top:4px;">Sabse common sawaalon ke jawab</div>
    </div>

    @php
    $faqs = [
        [
            'cat' => '💰 Deposit',
            'items' => [
                ['q' => 'Deposit kaise karte hain?', 'a' => 'Deposit → New Deposit pe jao. Hamara UPI ID pe payment karo. Phir UTR number aur screenshot submit karo. Admin 30 minute mein verify karke wallet credit kar dega.'],
                ['q' => 'Minimum deposit kitna hai?', 'a' => 'Minimum deposit ₹100 hai.'],
                ['q' => 'UTR number kahan milega?', 'a' => 'Apne payment app (PhonePe, GPay, Paytm) mein Transaction History mein jao. Wahan 12-digit UTR/Reference number milega.'],
                ['q' => 'Deposit approve hone mein kitna time lagta hai?', 'a' => 'Normal cases mein 15-30 minutes. Peak hours mein 1 ghante tak lag sakta hai.'],
                ['q' => 'Screenshot upload karna zaroori hai?', 'a' => 'Haan, screenshot aur UTR dono zaroori hain verification ke liye.'],
            ]
        ],
        [
            'cat' => '🏦 Withdrawal',
            'items' => [
                ['q' => 'Withdrawal kaise karte hain?', 'a' => 'Withdrawal → New Withdrawal pe jao. Amount enter karo, UPI ya Bank select karo, details bharo aur submit karo. Request Live Pool mein chali jayegi.'],
                ['q' => 'Minimum withdrawal kitna hai?', 'a' => 'Minimum withdrawal ₹100 hai.'],
                ['q' => 'Withdrawal kitne time mein process hota hai?', 'a' => 'Admin pool se request uthata hai aur process karta hai. Generally 30 minutes se 2 ghante mein complete ho jata hai.'],
                ['q' => 'Withdrawal fail ho gaya toh?', 'a' => 'Agar withdrawal fail hota hai toh amount automatically aapke Main Wallet mein wapas aa jata hai.'],
                ['q' => 'Live Pool kya hota hai?', 'a' => 'Saari withdrawal requests ek pool mein jati hain. Admin wahan se ek ek request process karta hai. Aap apni request ka status real-time mein dekh sakte ho.'],
            ]
        ],
        [
            'cat' => '🔗 Referral',
            'items' => [
                ['q' => 'Referral commission kaise milta hai?', 'a' => 'Jab aap apna referral code kisi ko dete ho aur wo register karke deposit/withdrawal karta hai, toh aapko commission milta hai. Deposit par 1% aur withdrawal par 0.5%.'],
                ['q' => 'Commission kahan jata hai?', 'a' => 'Commission seedha aapke Earnings Wallet mein credit hota hai.'],
                ['q' => 'Referral link kahan milega?', 'a' => 'Sidebar mein Referral pe click karo. Wahan aapka referral code aur shareable link milega.'],
                ['q' => 'Kitne log refer kar sakte hain?', 'a' => 'Koi limit nahi hai. Jitne zyada refer karoge, utna zyada earn karoge.'],
            ]
        ],
        [
            'cat' => '👛 Wallet',
            'items' => [
                ['q' => 'Teen wallets kya hain?', 'a' => 'Main Wallet: Deposit aur withdrawal ke liye. Earnings Wallet: Referral commission aur performance bonus. Pending Wallet: Processing mein rakha hua amount.'],
                ['q' => 'Earnings Wallet se paise kaise nikale?', 'a' => 'Earnings Wallet ka balance Withdrawal mein use hota hai. Support se contact karo transfer ke liye.'],
                ['q' => 'Security Hold kya hota hai?', 'a' => 'Kisi dispute ya suspicious activity par temporarily amount hold kiya jata hai. Support se contact karo resolution ke liye.'],
            ]
        ],
        [
            'cat' => '🔐 Account & Security',
            'items' => [
                ['q' => 'Password bhool gaya toh?', 'a' => 'Abhi forgot password feature nahi hai. Support ticket submit karo, admin reset kar dega.'],
                ['q' => 'Security PIN kya hai?', 'a' => 'Settings mein 6-digit PIN set kar sakte ho jo transaction verification ke liye use hota hai.'],
                ['q' => 'Account band ho gaya toh?', 'a' => 'Admin ne disable kiya hoga. Support ticket submit karo reason jaanne ke liye.'],
            ]
        ],
    ];
    @endphp

    @foreach($faqs as $section)
    <div class="mb-4">
        <div style="color:#f0a500; font-weight:700; font-size:1rem; margin-bottom:12px; padding-left:4px;">
            {{ $section['cat'] }}
        </div>
        <div class="accordion" id="acc{{ $loop->index }}">
            @foreach($section['items'] as $i => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq{{ $loop->parent->index }}_{{ $i }}">
                        {{ $faq['q'] }}
                    </button>
                </h2>
                <div id="faq{{ $loop->parent->index }}_{{ $i }}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <i class="bi bi-check-circle-fill me-2" style="color:#4cdf80;"></i>{{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:12px; padding:20px; text-align:center; margin-top:8px;">
        <div style="color:#c0c0e0; margin-bottom:12px;">Jawab nahi mila? Humse directly baat karo</div>
        <a href="{{ route('support.create') }}" class="btn btn-primary">
            <i class="bi bi-headset me-2"></i>Submit Support Ticket
        </a>
    </div>

</div>
</div>
@endsection
