<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - FastpayoutX</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --gold: #f5a623; --gold-light: #ffd166;
            --dark: #0a0a0f; --dark2: #12121a; --dark3: #1a1a28;
            --text: #e8e8f0; --text-muted: #8888aa;
        }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--text); }

        nav {
            position: fixed; top: 0; width: 100%; z-index: 100;
            padding: 16px 5%; display: flex; align-items: center; justify-content: space-between;
            background: rgba(10,10,15,0.95); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(245,166,35,0.1);
        }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo img { height: 34px; width: auto; }
        .logo-text {
            font-size: 1.3rem; font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .back-btn {
            padding: 8px 18px; border: 1px solid rgba(245,166,35,0.3);
            color: var(--gold); background: transparent; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.3s;
        }
        .back-btn:hover { background: rgba(245,166,35,0.1); }

        .page-hero {
            padding: 120px 5% 60px; text-align: center;
            background: radial-gradient(ellipse 70% 50% at 50% 0%, rgba(245,166,35,0.1) 0%, transparent 70%);
        }
        .page-tag {
            display: inline-block; color: var(--gold); font-size: 0.75rem;
            font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 14px;
        }
        .page-title { font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 14px; }
        .page-title span {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .page-meta { color: var(--text-muted); font-size: 0.9rem; }

        .content-wrap { max-width: 820px; margin: 0 auto; padding: 60px 5% 100px; }

        .section-block {
            background: var(--dark2); border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px; padding: 32px; margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        .section-block:hover { border-color: rgba(245,166,35,0.15); }
        .section-block h2 {
            font-size: 1.1rem; font-weight: 700; margin-bottom: 14px;
            display: flex; align-items: center; gap: 10px;
        }
        .section-block h2 .icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.2);
            display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
            flex-shrink: 0;
        }
        .section-block p, .section-block li {
            color: var(--text-muted); font-size: 0.92rem; line-height: 1.8;
        }
        .section-block ul { padding-left: 0; list-style: none; }
        .section-block ul li { padding: 5px 0 5px 20px; position: relative; }
        .section-block ul li::before {
            content: ''; position: absolute; left: 0; top: 14px;
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); opacity: 0.6;
        }

        .warning-box {
            background: rgba(245,100,35,0.06); border: 1px solid rgba(245,100,35,0.2);
            border-radius: 12px; padding: 20px 24px; margin-bottom: 20px;
        }
        .warning-box p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; }
        .warning-box strong { color: #ff8c42; }

        .highlight-box {
            background: rgba(245,166,35,0.06); border: 1px solid rgba(245,166,35,0.2);
            border-radius: 12px; padding: 20px 24px; margin-bottom: 20px;
        }
        .highlight-box p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; }
        .highlight-box strong { color: var(--gold); }

        footer {
            padding: 32px 5%; border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-logo { display: flex; align-items: center; gap: 8px; }
        .footer-logo img { height: 28px; }
        .footer-logo-text {
            font-size: 1.1rem; font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .footer-links { display: flex; gap: 20px; flex-wrap: wrap; }
        .footer-links a { color: var(--text-muted); text-decoration: none; font-size: 0.85rem; transition: color 0.3s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy { color: var(--text-muted); font-size: 0.8rem; }

        @media (max-width: 768px) {
            .page-hero { padding: 100px 5% 40px; }
            .content-wrap { padding: 40px 5% 60px; }
            .section-block { padding: 22px; }
            footer { flex-direction: column; align-items: center; text-align: center; }
        }
    </style>
</head>
<body>

<nav>
    <a href="/" class="logo">
        <img src="/logonew-removebg-preview.png" alt="FastpayoutX">
        <span class="logo-text">FastpayoutX</span>
    </a>
    <a href="/" class="back-btn">← Back to Home</a>
</nav>

<div class="page-hero">
    <span class="page-tag">Legal</span>
    <h1 class="page-title">Terms & <span>Conditions</span></h1>
    <p class="page-meta">Last updated: {{ date('F d, Y') }} &nbsp;·&nbsp; Please read carefully before using</p>
</div>

<div class="content-wrap">

    <div class="highlight-box">
        <p><strong>Agreement to Terms:</strong> By registering or using FastpayoutX, you confirm that you have read, understood, and agree to be bound by these Terms & Conditions. If you do not agree, please do not use our platform.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">✅</span> Eligibility</h2>
        <ul>
            <li>You must be at least 18 years of age to use FastpayoutX</li>
            <li>You must provide accurate and truthful information during registration</li>
            <li>One account per person — multiple accounts are strictly prohibited</li>
            <li>You must be a resident of a jurisdiction where our services are legally permitted</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">💰</span> Deposits & Withdrawals</h2>
        <ul>
            <li>All deposits must be made through the approved payment methods listed on the platform</li>
            <li>Minimum and maximum deposit/withdrawal limits apply as shown in your dashboard</li>
            <li>Withdrawals are processed within the timeframe specified on the platform</li>
            <li>FastpayoutX reserves the right to request identity verification before processing withdrawals</li>
            <li>Deposits made via incorrect details are non-refundable without proper verification</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🤝</span> Referral Program</h2>
        <ul>
            <li>Referral commissions are earned when your referred users complete qualifying activities</li>
            <li>Self-referrals or fake referrals using multiple accounts will result in immediate account termination</li>
            <li>Commission rates are subject to change at FastpayoutX's discretion with prior notice</li>
            <li>Referral bonuses are credited to your wallet and can be withdrawn as per standard withdrawal rules</li>
            <li>FastpayoutX reserves the right to withhold commissions if fraudulent activity is detected</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🚫</span> Prohibited Activities</h2>
        <ul>
            <li>Creating multiple accounts or using fake identities</li>
            <li>Money laundering, fraud, or any illegal financial activity</li>
            <li>Attempting to hack, exploit, or manipulate the platform</li>
            <li>Using bots, scripts, or automated tools to abuse the referral system</li>
            <li>Sharing your account credentials with any third party</li>
            <li>Engaging in any activity that disrupts platform operations</li>
        </ul>
    </div>

    <div class="warning-box">
        <p><strong>⚠️ Important:</strong> Violation of any prohibited activity will result in immediate account suspension, forfeiture of all balances, and may be reported to relevant authorities.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">🔐</span> Account Security</h2>
        <ul>
            <li>You are solely responsible for maintaining the confidentiality of your login credentials and PIN</li>
            <li>Immediately notify us of any unauthorized access to your account</li>
            <li>FastpayoutX will never ask for your password or PIN via email, phone, or chat</li>
            <li>We are not liable for losses resulting from your failure to secure your account</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">⚖️</span> Limitation of Liability</h2>
        <p style="margin-bottom:12px">FastpayoutX shall not be liable for:</p>
        <ul>
            <li>Losses due to technical failures, server downtime, or maintenance periods</li>
            <li>Losses resulting from unauthorized account access due to user negligence</li>
            <li>Delays in payment processing caused by third-party payment providers</li>
            <li>Any indirect, incidental, or consequential damages arising from platform use</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🔄</span> Modifications to Terms</h2>
        <p>FastpayoutX reserves the right to modify these Terms & Conditions at any time. Updated terms will be posted on this page with a revised date. Continued use of the platform after changes constitutes your acceptance of the new terms.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">❌</span> Account Termination</h2>
        <p>FastpayoutX reserves the right to suspend or permanently terminate any account that violates these terms, engages in fraudulent activity, or poses a risk to the platform or other users. In such cases, pending balances may be forfeited.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">📞</span> Contact & Disputes</h2>
        <p>For any questions regarding these terms or to raise a dispute, please contact us through the <a href="{{ route('support.index') }}" style="color:var(--gold);text-decoration:none">Support</a> section in your dashboard. We aim to resolve all disputes within 7 business days.</p>
    </div>

</div>

<footer>
    <div class="footer-logo">
        <img src="/logonew-removebg-preview.png" alt="FastpayoutX">
        <span class="footer-logo-text">FastpayoutX</span>
    </div>
    <div class="footer-links">
        <a href="/">Home</a>
        <a href="{{ route('privacy') }}">Privacy Policy</a>
        <a href="{{ route('terms') }}">Terms & Conditions</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
    <div class="footer-copy">© {{ date('Y') }} FastpayoutX. All rights reserved.</div>
</footer>

</body>
</html>
