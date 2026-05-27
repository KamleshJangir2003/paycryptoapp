<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastpayoutX - Fast & Secure Payments</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #f5a623;
            --gold-light: #ffd166;
            --dark: #0a0a0f;
            --dark2: #12121a;
            --dark3: #1a1a28;
            --text: #e8e8f0;
            --text-muted: #8888aa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        nav {
            position: fixed; top: 0; width: 100%; z-index: 100;
            padding: 18px 5%;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(10,10,15,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(245,166,35,0.1);
            animation: slideDown 0.6s ease;
        }

        .logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .logo img { height: 40px; width: auto; object-fit: contain; }
        .logo-text {
            font-size: 1.4rem; font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-links { display: flex; gap: 32px; list-style: none; }
        .nav-links a {
            color: var(--text-muted); text-decoration: none; font-size: 0.9rem;
            font-weight: 500; transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--gold); }

        .nav-btns { display: flex; gap: 12px; }

        .btn-outline {
            padding: 9px 22px; border: 1px solid rgba(245,166,35,0.4);
            color: var(--gold); background: transparent; border-radius: 8px;
            font-size: 0.875rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: all 0.3s;
        }
        .btn-outline:hover { background: rgba(245,166,35,0.1); border-color: var(--gold); }

        .btn-primary {
            padding: 9px 22px;
            background: linear-gradient(135deg, var(--gold), #e8940f);
            color: #0a0a0f; border: none; border-radius: 8px;
            font-size: 0.875rem; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: all 0.3s;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(245,166,35,0.4); }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 120px 5% 80px;
            position: relative; overflow: hidden;
        }

        .hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(245,166,35,0.12) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(245,166,35,0.06) 0%, transparent 60%);
        }

        /* Floating orbs */
        .orb {
            position: absolute; border-radius: 50%;
            filter: blur(80px); animation: float 8s ease-in-out infinite;
        }
        .orb1 { width: 400px; height: 400px; background: rgba(245,166,35,0.08); top: 10%; left: -10%; animation-delay: 0s; }
        .orb2 { width: 300px; height: 300px; background: rgba(245,166,35,0.06); bottom: 10%; right: -5%; animation-delay: 3s; }
        .orb3 { width: 200px; height: 200px; background: rgba(255,209,102,0.05); top: 50%; left: 60%; animation-delay: 5s; }

        .hero-content { position: relative; z-index: 1; max-width: 800px; }

        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.25);
            color: var(--gold); padding: 6px 16px; border-radius: 50px;
            font-size: 0.8rem; font-weight: 600; margin-bottom: 28px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .badge-dot {
            width: 6px; height: 6px; background: var(--gold);
            border-radius: 50%; animation: pulse 2s infinite;
        }

        h1 {
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 900; line-height: 1.1;
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        h1 .highlight {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.15rem; color: var(--text-muted); line-height: 1.7;
            max-width: 560px; margin: 0 auto 40px;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .hero-btns {
            display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.8s both;
        }

        .btn-hero {
            padding: 14px 32px; border-radius: 10px;
            font-size: 1rem; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: all 0.3s;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--gold), #e8940f);
            color: #0a0a0f; border: none;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(245,166,35,0.45); }

        .btn-hero-secondary {
            background: rgba(255,255,255,0.05); color: var(--text);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.1); transform: translateY(-2px); }

        /* Stats bar */
        .stats-bar {
            display: flex; justify-content: center; gap: 48px; flex-wrap: wrap;
            margin-top: 64px; padding-top: 48px;
            border-top: 1px solid rgba(255,255,255,0.06);
            animation: fadeInUp 0.8s ease 1s both;
        }

        .stat { text-align: center; }
        .stat-num {
            font-size: 2rem; font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }

        /* ===== FEATURES ===== */
        .section {
            padding: 100px 5%;
            max-width: 1200px; margin: 0 auto;
        }

        .section-tag {
            display: inline-block; color: var(--gold);
            font-size: 0.8rem; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; margin-bottom: 16px;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem); font-weight: 800;
            line-height: 1.2; margin-bottom: 16px;
        }

        .section-sub { color: var(--text-muted); font-size: 1.05rem; max-width: 500px; }

        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px; margin-top: 60px;
        }

        .feature-card {
            background: var(--dark2);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px; padding: 32px;
            transition: all 0.4s ease;
            position: relative; overflow: hidden;
        }

        .feature-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0; transition: opacity 0.4s;
        }

        .feature-card:hover { transform: translateY(-6px); border-color: rgba(245,166,35,0.2); }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 52px; height: 52px; border-radius: 12px;
            background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 20px;
        }

        .feature-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
        .feature-desc { color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; }

        /* ===== HOW IT WORKS ===== */
        .how-section {
            padding: 100px 5%;
            background: var(--dark2);
        }

        .how-inner { max-width: 1200px; margin: 0 auto; }

        .steps {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 32px; margin-top: 60px; position: relative;
        }

        .step {
            text-align: center; padding: 32px 24px;
            background: var(--dark3); border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: transform 0.3s;
        }
        .step:hover { transform: translateY(-4px); }

        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #e8940f);
            color: #0a0a0f; font-size: 1.3rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }

        .step-title { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
        .step-desc { color: var(--text-muted); font-size: 0.875rem; line-height: 1.6; }

        /* ===== CTA ===== */
        .cta-section {
            padding: 100px 5%; text-align: center;
            position: relative; overflow: hidden;
        }

        .cta-bg {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 80% at 50% 50%, rgba(245,166,35,0.08) 0%, transparent 70%);
        }

        .cta-inner { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }

        .cta-title { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 20px; }
        .cta-desc { color: var(--text-muted); font-size: 1.05rem; margin-bottom: 40px; line-height: 1.7; }

        /* ===== FOOTER ===== */
        footer {
            padding: 40px 5%;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }

        .footer-logo {
            display: flex; align-items: center; gap: 8px;
        }
        .footer-logo img { height: 30px; width: auto; }
        .footer-logo-text {
            font-size: 1.2rem; font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .footer-links { display: flex; gap: 24px; }
        .footer-links a { color: var(--text-muted); text-decoration: none; font-size: 0.875rem; transition: color 0.3s; }
        .footer-links a:hover { color: var(--gold); }

        .footer-copy { color: var(--text-muted); font-size: 0.8rem; }

        /* ===== ANIMATIONS ===== */
        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ===== HAMBURGER ===== */
        .hamburger {
            display: none; flex-direction: column; gap: 5px;
            cursor: pointer; padding: 4px; background: none; border: none;
        }
        .hamburger span {
            display: block; width: 24px; height: 2px;
            background: var(--text); border-radius: 2px;
            transition: all 0.3s;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        .mobile-menu {
            display: none; position: fixed; top: 73px; left: 0; right: 0;
            background: rgba(10,10,15,0.97); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(245,166,35,0.1);
            padding: 24px 5%; flex-direction: column; gap: 20px; z-index: 99;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            color: var(--text-muted); text-decoration: none; font-size: 1rem;
            font-weight: 500; padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: color 0.3s;
        }
        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu a:hover { color: var(--gold); }
        .mobile-menu .mob-btns {
            display: flex; gap: 12px; padding-top: 8px;
        }
        .mobile-menu .mob-btns a {
            flex: 1; text-align: center; border-bottom: none; padding: 11px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            nav { padding: 14px 5%; }
            .nav-links { display: none; }
            .nav-btns { display: none; }
            .hamburger { display: flex; }
            .logo img { height: 32px; }
            .logo-text { font-size: 1.2rem; }

            .hero { padding: 100px 5% 60px; min-height: auto; }
            h1 { font-size: clamp(2rem, 8vw, 2.8rem); }
            .hero-desc { font-size: 1rem; }
            .btn-hero { padding: 13px 24px; font-size: 0.95rem; width: 100%; text-align: center; }
            .hero-btns { flex-direction: column; align-items: center; }

            .stats-bar { gap: 0; margin-top: 48px; padding-top: 32px; }
            .stat { flex: 1 1 50%; padding: 12px 0; }
            .stat-num { font-size: 1.6rem; }

            .section { padding: 64px 5%; }
            .features-grid { grid-template-columns: 1fr; gap: 16px; margin-top: 40px; }
            .feature-card { padding: 24px; }

            .how-section { padding: 64px 5%; }
            .steps { grid-template-columns: 1fr; gap: 16px; margin-top: 40px; }
            .step { padding: 24px 20px; }

            .cta-section { padding: 64px 5%; }
            .cta-desc { font-size: 0.95rem; }
            .cta-title { font-size: clamp(1.6rem, 6vw, 2.2rem); }

            footer { flex-direction: column; align-items: center; text-align: center; gap: 20px; padding: 32px 5%; }
            .footer-links { flex-wrap: wrap; justify-content: center; gap: 16px; }

            .orb1 { width: 250px; height: 250px; }
            .orb2 { width: 180px; height: 180px; }
            .orb3 { display: none; }
        }

        @media (max-width: 400px) {
            .logo-text { display: none; }
            h1 { font-size: 1.9rem; }
            .stat { flex: 1 1 100%; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="/" class="logo">
        <img src="/logonew-removebg-preview.png" alt="FastpayoutX">
        <span class="logo-text">FastpayoutX</span>
    </a>
    <ul class="nav-links">
        <li><a href="#features">Features</a></li>
        <li><a href="#how">How It Works</a></li>
        <li><a href="#referral">Referral</a></li>
    </ul>
    <div class="nav-btns">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="btn-outline">Login</a>
        @endif
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
        @endif
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <a href="#features" onclick="closeMenu()">Features</a>
    <a href="#how" onclick="closeMenu()">How It Works</a>
    <a href="#referral" onclick="closeMenu()">Referral</a>
    <div class="mob-btns">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="btn-outline">Login</a>
        @endif
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
        @endif
    </div>
</div>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg">
        <div class="orb orb1"></div>
        <div class="orb orb2"></div>
        <div class="orb orb3"></div>
    </div>
    <div class="hero-content">
        <div class="badge">
            <span class="badge-dot"></span>
            Trusted Payment Platform
        </div>
        <h1>
            Fast, Secure &<br>
            <span class="highlight">Smart Payouts</span>
        </h1>
        <p class="hero-desc">
            FastpayoutX gives you full control over your money — deposit, withdraw, earn referral bonuses, and track every transaction in real time.
        </p>
        <div class="hero-btns">
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Start Earning Now</a>
            @endif
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn-hero btn-hero-secondary">Login to Dashboard</a>
            @endif
        </div>
        <div class="stats-bar">
            <div class="stat">
                <div class="stat-num">10K+</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat">
                <div class="stat-num">₹50L+</div>
                <div class="stat-label">Processed Daily</div>
            </div>
            <div class="stat">
                <div class="stat-num">99.9%</div>
                <div class="stat-label">Uptime</div>
            </div>
            <div class="stat">
                <div class="stat-num">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features">
    <div class="section">
        <div class="reveal">
            <span class="section-tag">Why FastpayoutX</span>
            <h2 class="section-title">Everything you need<br>in one platform</h2>
            <p class="section-sub">Powerful tools to manage your money, grow your network, and maximize earnings.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-icon">⚡</div>
                <div class="feature-title">Instant Deposits</div>
                <div class="feature-desc">Add funds to your wallet instantly with multiple payment methods. No delays, no hassle.</div>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon">💸</div>
                <div class="feature-title">Fast Withdrawals</div>
                <div class="feature-desc">Withdraw your earnings directly to your bank account. Quick processing, every time.</div>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon">🤝</div>
                <div class="feature-title">Referral Bonuses</div>
                <div class="feature-desc">Invite friends and earn commissions on their activity. Build your network, grow your income.</div>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Live Reports</div>
                <div class="feature-desc">Track all transactions, commissions, and performance bonuses in real-time dashboards.</div>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon">🔒</div>
                <div class="feature-title">Secure & Safe</div>
                <div class="feature-desc">Bank-grade security with PIN protection and encrypted transactions to keep your funds safe.</div>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon">💬</div>
                <div class="feature-title">24/7 Support</div>
                <div class="feature-desc">Live chat support available around the clock. We're always here when you need us.</div>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section id="how" class="how-section">
    <div class="how-inner">
        <div class="reveal" style="text-align:center">
            <span class="section-tag">Simple Process</span>
            <h2 class="section-title">Get started in minutes</h2>
            <p class="section-sub" style="margin:0 auto">Four simple steps to start earning with FastpayoutX.</p>
        </div>
        <div class="steps">
            <div class="step reveal">
                <div class="step-num">1</div>
                <div class="step-title">Create Account</div>
                <div class="step-desc">Register with your mobile number and verify with OTP in seconds.</div>
            </div>
            <div class="step reveal">
                <div class="step-num">2</div>
                <div class="step-title">Make a Deposit</div>
                <div class="step-desc">Add funds to your wallet using our secure payment gateway.</div>
            </div>
            <div class="step reveal">
                <div class="step-num">3</div>
                <div class="step-title">Invite & Earn</div>
                <div class="step-desc">Share your referral link and earn commissions on every referral.</div>
            </div>
            <div class="step reveal">
                <div class="step-num">4</div>
                <div class="step-title">Withdraw Anytime</div>
                <div class="step-desc">Cash out your earnings to your bank account whenever you want.</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section id="referral" class="cta-section">
    <div class="cta-bg"></div>
    <div class="cta-inner reveal">
        <span class="section-tag">Join Today</span>
        <h2 class="cta-title">Ready to start<br><span style="background:linear-gradient(135deg,#f5a623,#ffd166);-webkit-background-clip:text;-webkit-text-fill-color:transparent">earning with FastpayoutX?</span></h2>
        <p class="cta-desc">Join thousands of users who trust FastpayoutX for fast, secure, and rewarding payments.</p>
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Create Free Account</a>
        @endif
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">
        <img src="/logonew-removebg-preview.png" alt="FastpayoutX">
        <span class="footer-logo-text">FastpayoutX</span>
    </div>
    <div class="footer-links">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
        <a href="{{ route('privacy') }}">Privacy Policy</a>
        <a href="{{ route('terms') }}">Terms & Conditions</a>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
        @endauth
    </div>
    <div class="footer-copy">© {{ date('Y') }} FastpayoutX. All rights reserved.</div>
</footer>

<script>
    // Hamburger menu
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
    });

    function closeMenu() {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
    }

    // Close menu on outside click
    document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
            closeMenu();
        }
    });

    // Scroll reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 100);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Counter animation
    function animateCounter(el, target, suffix = '') {
        let start = 0;
        const duration = 2000;
        const step = target / (duration / 16);
        const timer = setInterval(() => {
            start += step;
            if (start >= target) { el.textContent = target + suffix; clearInterval(timer); return; }
            el.textContent = Math.floor(start) + suffix;
        }, 16);
    }

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const nums = entry.target.querySelectorAll('.stat-num');
                nums[0] && animateCounter(nums[0], 10, 'K+');
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsBar = document.querySelector('.stats-bar');
    if (statsBar) statsObserver.observe(statsBar);
</script>
</body>
</html>
