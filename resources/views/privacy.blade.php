<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - FastpayoutX</title>
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
        .page-title {
            font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 14px;
        }
        .page-title span {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .page-meta { color: var(--text-muted); font-size: 0.9rem; }

        .content-wrap {
            max-width: 820px; margin: 0 auto; padding: 60px 5% 100px;
        }

        .section-block {
            background: var(--dark2); border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px; padding: 32px; margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        .section-block:hover { border-color: rgba(245,166,35,0.15); }

        .section-block h2 {
            font-size: 1.1rem; font-weight: 700; margin-bottom: 14px;
            display: flex; align-items: center; gap: 10px; color: var(--text);
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
        .section-block ul li {
            padding: 5px 0 5px 20px; position: relative;
        }
        .section-block ul li::before {
            content: ''; position: absolute; left: 0; top: 14px;
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); opacity: 0.6;
        }

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
    <h1 class="page-title">Privacy <span>Policy</span></h1>
    <p class="page-meta">Last updated: {{ date('F d, Y') }} &nbsp;·&nbsp; Effective immediately</p>
</div>

<div class="content-wrap">

    <div class="highlight-box">
        <p><strong>Your privacy matters to us.</strong> This policy explains how FastpayoutX collects, uses, and protects your personal information when you use our platform. By using FastpayoutX, you agree to the practices described below.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">📋</span> Information We Collect</h2>
        <ul>
            <li>Full name, mobile number, and email address during registration</li>
            <li>Bank account details and UPI ID for withdrawal processing</li>
            <li>Transaction history including deposits, withdrawals, and commissions</li>
            <li>Device information, IP address, and browser type for security purposes</li>
            <li>Referral activity and network data</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🎯</span> How We Use Your Information</h2>
        <ul>
            <li>To process deposits, withdrawals, and referral commissions</li>
            <li>To verify your identity and prevent fraudulent activity</li>
            <li>To send transaction alerts and important account notifications</li>
            <li>To provide customer support and resolve disputes</li>
            <li>To improve our platform features and user experience</li>
            <li>To comply with applicable laws and regulations</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🔒</span> Data Security</h2>
        <p>We implement industry-standard security measures to protect your data:</p>
        <ul>
            <li>All data is encrypted in transit using SSL/TLS protocols</li>
            <li>Passwords are hashed using bcrypt — we never store plain-text passwords</li>
            <li>Transaction PINs are encrypted and never visible to our staff</li>
            <li>Regular security audits and vulnerability assessments are conducted</li>
            <li>Access to user data is restricted to authorized personnel only</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🤝</span> Data Sharing</h2>
        <p style="margin-bottom:12px">We do <strong style="color:var(--text)">not</strong> sell or rent your personal data to third parties. We may share data only in these limited cases:</p>
        <ul>
            <li>With payment processors to complete your transactions</li>
            <li>With law enforcement when legally required</li>
            <li>With service providers who assist in platform operations (under strict confidentiality)</li>
        </ul>
    </div>

    <div class="section-block">
        <h2><span class="icon">🍪</span> Cookies</h2>
        <p>We use essential cookies to maintain your login session and platform preferences. We do not use tracking or advertising cookies. You can disable cookies in your browser settings, but this may affect platform functionality.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">👤</span> Your Rights</h2>
        <ul>
            <li>Request access to the personal data we hold about you</li>
            <li>Request correction of inaccurate or incomplete data</li>
            <li>Request deletion of your account and associated data</li>
            <li>Withdraw consent for data processing at any time</li>
        </ul>
        <p style="margin-top:14px">To exercise any of these rights, contact us via the Support section in your dashboard.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">📝</span> Policy Updates</h2>
        <p>We may update this Privacy Policy from time to time. Any significant changes will be communicated via email or an in-app notification. Continued use of FastpayoutX after changes constitutes acceptance of the updated policy.</p>
    </div>

    <div class="section-block">
        <h2><span class="icon">📞</span> Contact Us</h2>
        <p>For any privacy-related questions or concerns, please reach out through the <a href="{{ route('support.index') }}" style="color:var(--gold);text-decoration:none">Support</a> section after logging in, or email us at <span style="color:var(--gold)">support@fastpayoutx.com</span></p>
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
