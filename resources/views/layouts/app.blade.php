<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastPayz - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background: #0d0d1a; color: #f0f0f0; font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px; height: 100vh;
            background: #13132b;
            border-right: 1px solid #2a2a50;
            position: fixed; top: 0; left: 0; z-index: 200;
            display: flex; flex-direction: column;
            transition: transform .3s;
            overflow: hidden;
        }
        .sidebar-brand {
            padding: 12px 16px;
            border-bottom: 1px solid #2a2a50;
            display: flex; align-items: center; justify-content: center;
            min-height: 90px;
        }
        .sidebar-brand img { max-width: 200px; max-height: 70px; width: auto; height: 70px; object-fit: contain; display: block; }
        .sidebar nav { flex: 1; padding: 10px 0; overflow-y: auto; overflow-x: hidden; }
        .sidebar nav::-webkit-scrollbar { width: 4px; }
        .sidebar nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar nav::-webkit-scrollbar-thumb { background: #2a2a50; border-radius: 4px; }
        .sidebar nav::-webkit-scrollbar-thumb:hover { background: #f0a500; }
        .nav-link {
            color: #b0b0cc !important;
            padding: 12px 22px;
            display: flex; align-items: center; gap: 12px;
            font-size: .95rem; font-weight: 500;
            border-left: 3px solid transparent;
            transition: all .2s;
            text-decoration: none;
        }
        .nav-link i { font-size: 1.1rem; width: 20px; }
        .nav-link:hover { color: #f0f0f0 !important; background: #1e1e40; border-left-color: #f0a500; }
        .nav-link.active { color: #f0a500 !important; background: #1e1e40; border-left-color: #f0a500; font-weight: 600; }
        .sidebar-divider { border-color: #2a2a50; margin: 8px 20px; }

        /* ── Main ── */
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background: #13132b;
            border-bottom: 1px solid #2a2a50;
            padding: 10px 20px;
            display: flex; align-items: center; gap: 14px;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-logo { height: 44px; width: auto; object-fit: contain; flex-shrink: 0; }
        .topbar-user-info { display: flex; flex-direction: column; justify-content: center; flex: 1; min-width: 0; }
        .topbar-name { color: #f0f0f0; font-weight: 700; font-size: .95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .topbar-mobile { color: #f0a500; font-size: .78rem; white-space: nowrap; }
        .hamburger { background: none; border: none; color: #f0f0f0; font-size: 1.6rem; cursor: pointer; flex-shrink: 0; padding: 0; line-height: 1; }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: #f0f0f0; }
        .topbar-user { text-align: right; flex-shrink: 0; }
        .topbar-user .name { color: #f0f0f0; font-weight: 600; font-size: .85rem; }
        .topbar-user .mobile { color: #f0a500; font-size: .75rem; }
        .page-body { padding: 24px 28px; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .page-body { padding: 16px; }
            .topbar { padding: 8px 14px; gap: 10px; }
            .topbar-logo { height: 36px; }
            .topbar-name { font-size: .85rem; }
            .topbar-mobile { font-size: .72rem; }
        }
        @media (max-width: 480px) {
            .topbar { padding: 8px 10px; gap: 8px; }
            .topbar-logo { height: 30px; }
        }

        /* ── Cards ── */
        .card { background: #13132b; border: 1px solid #2a2a50; border-radius: 14px; }
        .card-header {
            background: #1a1a38; border-bottom: 1px solid #2a2a50;
            border-radius: 14px 14px 0 0 !important;
            padding: 14px 20px; color: #f0f0f0; font-weight: 600;
        }
        .card-body { color: #e0e0f0; }

        /* ── Stat Cards ── */
        .stat-card {
            background: linear-gradient(135deg, #13132b 0%, #1e1e40 100%);
            border: 1px solid #2a2a50; border-radius: 14px;
            padding: 20px; position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: -20px; right: -20px;
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(240,165,0,.08);
        }
        .stat-card .stat-label { color: #8888aa; font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .stat-card .stat-value { font-size: 1.7rem; font-weight: 800; color: #f0a500; line-height: 1; }
        .stat-card .stat-value.green { color: #4cdf80; }
        .stat-card .stat-value.orange { color: #ff9800; }
        .stat-card .stat-value.blue { color: #4db8ff; }

        /* ── Table ── */
        .table { color: #e0e0f0; }
        .table thead th { background: #1a1a38; color: #aaaacc; border-color: #2a2a50; font-size: .82rem; text-transform: uppercase; letter-spacing: .5px; padding: 12px 16px; }
        .table td { border-color: #1e1e38; padding: 12px 16px; vertical-align: middle; color: #e0e0f0; }
        .table tbody tr:hover { background: #1a1a38; }

        /* ── Badges ── */
        .badge-pending   { background: #ff9800 !important; color: #000 !important; }
        .badge-approved  { background: #4cdf80 !important; color: #000 !important; }
        .badge-completed { background: #4cdf80 !important; color: #000 !important; }
        .badge-rejected  { background: #ff4d4d !important; color: #fff !important; }
        .badge-failed    { background: #ff4d4d !important; color: #fff !important; }
        .badge-processing{ background: #4db8ff !important; color: #000 !important; }
        .badge-open      { background: #ff9800 !important; color: #000 !important; }
        .badge-replied   { background: #4cdf80 !important; color: #000 !important; }
        .badge-closed    { background: #888 !important; color: #fff !important; }

        /* ── Buttons ── */
        .btn-primary { background: #f0a500; border-color: #f0a500; color: #000; font-weight: 700; }
        .btn-primary:hover, .btn-primary:focus { background: #d4920a; border-color: #d4920a; color: #000; }
        .btn-success { background: #4cdf80; border-color: #4cdf80; color: #000; font-weight: 600; }
        .btn-success:hover { background: #3bc96e; border-color: #3bc96e; color: #000; }
        .btn-danger { background: #ff4d4d; border-color: #ff4d4d; color: #fff; font-weight: 600; }
        .btn-danger:hover { background: #e03c3c; border-color: #e03c3c; }
        .btn-outline-secondary { border-color: #3a3a60; color: #b0b0cc; }
        .btn-outline-secondary:hover { background: #2a2a50; color: #f0f0f0; border-color: #4a4a70; }

        /* ── Forms ── */
        .form-control, .form-select {
            background: #0d0d1a; border: 1px solid #3a3a60;
            color: #f0f0f0; border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background: #0d0d1a; border-color: #f0a500;
            color: #f0f0f0; box-shadow: 0 0 0 3px rgba(240,165,0,.15);
        }
        .form-control::placeholder { color: #5a5a80; }
        .form-label { color: #c0c0e0; font-weight: 500; font-size: .9rem; margin-bottom: 6px; }
        .form-select option { background: #13132b; color: #f0f0f0; }

        /* ── Alerts ── */
        .alert-success { background: #0d2a1a; border: 1px solid #4cdf80; color: #4cdf80; border-radius: 10px; }
        .alert-danger  { background: #2a0d0d; border: 1px solid #ff4d4d; color: #ff8080; border-radius: 10px; }

        /* ── Pool item ── */
        .pool-item { background: #0d0d1a; border: 1px solid #2a2a50; border-radius: 10px; padding: 14px; margin-bottom: 10px; }
        .pool-item:hover { border-color: #f0a500; }

        /* ── Info box ── */
        .info-box { background: #0d0d1a; border: 1px solid #3a3a60; border-radius: 10px; padding: 16px; }

        /* ── Reports Dropdown ── */
        .nav-dropdown-btn {
            color: #b0b0cc;
            padding: 12px 22px;
            display: flex; align-items: center; gap: 12px;
            font-size: .95rem; font-weight: 500;
            border-left: 3px solid transparent;
            transition: all .2s;
            cursor: pointer;
            background: none; border-top: none; border-right: none; border-bottom: none;
            width: 100%; text-align: left;
        }
        .nav-dropdown-btn:hover { color: #f0f0f0; background: #1e1e40; border-left-color: #f0a500; }
        .nav-dropdown-btn.open { color: #f0a500; background: #1e1e40; border-left-color: #f0a500; }
        .nav-dropdown-btn .arrow { margin-left: auto; font-size: .75rem; transition: transform .2s; }
        .nav-dropdown-btn.open .arrow { transform: rotate(180deg); }
        .nav-sub { display: none; background: #0d0d1a; border-left: 3px solid #f0a500; }
        .nav-sub.open { display: block; }
        .nav-sub .nav-link { padding: 9px 22px 9px 44px; font-size: .88rem; border-left: none; }
        .nav-sub .nav-link:hover { background: #1a1a38; border-left: none; }
        .nav-sub .nav-link.active { color: #f0a500 !important; background: #1a1a38; border-left: none; }
        .hamburger { background: none; border: none; color: #f0f0f0; font-size: 1.6rem; cursor: pointer; flex-shrink: 0; padding: 0; line-height: 1; }
        .topbar-logo { height: 44px; width: auto; object-fit: contain; flex-shrink: 0; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 199; }

        /* ── Responsive ── */
        @media (min-width: 769px) {
            .hamburger { display: none; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .stat-card .stat-value { font-size: 1.4rem; }
        }

        /* ── Pagination ── */
        .pagination .page-link { background: #13132b; border-color: #2a2a50; color: #b0b0cc; }
        .pagination .page-link:hover { background: #1e1e40; color: #f0a500; }
        .pagination .page-item.active .page-link { background: #f0a500; border-color: #f0a500; color: #000; }

        /* ── Accordion (FAQ) ── */
        .accordion-button { background: #1a1a38 !important; color: #f0f0f0 !important; font-weight: 500; }
        .accordion-button:not(.collapsed) { color: #f0a500 !important; box-shadow: none; }
        .accordion-button::after { filter: invert(1); }
        .accordion-item { background: #13132b; border: 1px solid #2a2a50 !important; border-radius: 10px !important; margin-bottom: 8px; overflow: hidden; }
        .accordion-body { background: #0d0d1a; color: #c0c0e0; }

        /* ── Nav tabs ── */
        .nav-tabs .nav-link { color: #8888aa !important; border-color: transparent; border-bottom-color: #2a2a50; }
        .nav-tabs .nav-link.active { color: #f0a500 !important; background: transparent; border-color: #2a2a50 #2a2a50 #0d0d1a; font-weight: 600; }
        .nav-tabs { border-bottom-color: #2a2a50; }

        /* ── Progress ── */
        .progress { background: #0d0d1a; border-radius: 10px; }

        /* ── Text helpers ── */
        .text-gold { color: #f0a500 !important; }
        .text-green { color: #4cdf80 !important; }
        .text-red { color: #ff4d4d !important; }
        .text-blue { color: #4db8ff !important; }
        .text-muted { color: #7777aa !important; }
        .text-white { color: #f0f0f0 !important; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand"><img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastPayz"></div>
    <nav>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('deposit.index') }}" class="nav-link {{ request()->routeIs('deposit.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-circle-fill"></i> Deposit
        </a>
        <a href="{{ route('withdrawal.index') }}" class="nav-link {{ request()->routeIs('withdrawal.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-up-circle-fill"></i> Withdrawal
        </a>
        <a href="{{ route('referral') }}" class="nav-link {{ request()->routeIs('referral') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Referral
        </a>

        {{-- Reports Dropdown --}}
        @php $reportsOpen = request()->routeIs('reports*'); @endphp
        <button class="nav-dropdown-btn {{ $reportsOpen ? 'open' : '' }}" onclick="toggleDropdown('reports')" id="reportsBtn">
            <i class="bi bi-bar-chart-fill" style="font-size:1.1rem; width:20px;"></i>
            Reports
            <i class="bi bi-chevron-down arrow"></i>
        </button>
        <div class="nav-sub {{ $reportsOpen ? 'open' : '' }}" id="reportsSub">
            <a href="{{ route('reports.finance') }}" class="nav-link {{ request()->routeIs('reports.finance') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Finance Report
            </a>
            <a href="{{ route('reports.adjustment') }}" class="nav-link {{ request()->routeIs('reports.adjustment') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Adjustment
            </a>
        </div>

        {{-- Help Dropdown --}}
        @php $helpOpen = request()->routeIs('support.*') || request()->routeIs('faq') || request()->routeIs('tutorial'); @endphp
        <button class="nav-dropdown-btn {{ $helpOpen ? 'open' : '' }}" onclick="toggleDropdown('help')" id="helpBtn">
            <i class="bi bi-question-circle-fill" style="font-size:1.1rem; width:20px;"></i>
            Help
            <i class="bi bi-chevron-down arrow"></i>
        </button>
        <div class="nav-sub {{ $helpOpen ? 'open' : '' }}" id="helpSub">
            <a href="{{ route('chat') }}" class="nav-link {{ request()->routeIs('chat') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Support Chat
            </a>
            <a href="{{ route('support.index') }}" class="nav-link {{ request()->routeIs('support.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i> Tickets
            </a>
            <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">
                <i class="bi bi-patch-question-fill"></i> FAQ
            </a>
            <a href="{{ route('tutorial') }}" class="nav-link {{ request()->routeIs('tutorial') ? 'active' : '' }}">
                <i class="bi bi-play-circle-fill"></i> Tutorial
            </a>
        </div>

        {{-- Settings Dropdown --}}
        @php $settingsOpen = request()->routeIs('settings') || request()->routeIs('settings.pin'); @endphp
        <button class="nav-dropdown-btn {{ $settingsOpen ? 'open' : '' }}" onclick="toggleDropdown('settings')" id="settingsBtn">
            <i class="bi bi-gear-fill" style="font-size:1.1rem; width:20px;"></i>
            Settings
            <i class="bi bi-chevron-down arrow"></i>
        </button>
        <div class="nav-sub {{ $settingsOpen ? 'open' : '' }}" id="settingsSub">
            <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i> Profile
            </a>
        </div>

        <a href="{{ route('settings.bank.page') }}" class="nav-link {{ request()->routeIs('settings.bank.page') ? 'active' : '' }}">
            <i class="bi bi-bank"></i> Bank Details
        </a>
        <a href="{{ route('settings.password.page') }}" class="nav-link {{ request()->routeIs('settings.password.page') ? 'active' : '' }}">
            <i class="bi bi-lock-fill"></i> Change Password
        </a>

        <hr class="sidebar-divider">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start" style="cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3 d-md-none">
            <img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastPayz" class="topbar-logo">
            <div class="topbar-user-info">
                <div class="topbar-name">{{ auth()->user()->name }}</div>
                <div class="topbar-mobile">{{ auth()->user()->mobile }}</div>
            </div>
            <button class="hamburger ms-auto" onclick="openSidebar()"><i class="bi bi-list"></i></button>
        </div>
        <div class="d-none d-md-flex align-items-center justify-content-between w-100">
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-user">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="mobile">{{ auth()->user()->mobile }}</div>
            </div>
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success mb-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-4"><i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                @foreach($errors->all() as $e)<div><i class="bi bi-x-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openSidebar()  { document.getElementById('sidebar').classList.add('open'); document.getElementById('overlay').classList.add('open'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('open'); }
function toggleDropdown(name) {
    const btn = document.getElementById(name + 'Btn');
    const sub = document.getElementById(name + 'Sub');
    btn.classList.toggle('open');
    sub.classList.toggle('open');
}
// backward compat
function toggleHelp() { toggleDropdown('help'); }
</script>
@yield('scripts')
</body>
</html>
