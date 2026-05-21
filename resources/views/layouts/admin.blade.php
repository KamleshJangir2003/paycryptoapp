<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastPayz Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background: #0a0a14; color: #f0f0f0; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 240px; min-height: 100vh; background: #10102a; border-right: 1px solid #2a2a50; position: fixed; top: 0; left: 0; z-index: 200; display: flex; flex-direction: column; transition: transform .3s; }
        .sidebar-brand { padding: 22px 20px; font-size: 1.3rem; font-weight: 800; color: #ff4d4d; border-bottom: 1px solid #2a2a50; }
        .sidebar-brand span { color: #ffffff; }
        .sidebar nav { flex: 1; padding: 10px 0; }
        .nav-link { color: #b0b0cc !important; padding: 12px 22px; display: flex; align-items: center; gap: 12px; font-size: .95rem; font-weight: 500; border-left: 3px solid transparent; transition: all .2s; text-decoration: none; }
        .nav-link i { font-size: 1.1rem; width: 20px; }
        .nav-link:hover { color: #f0f0f0 !important; background: #1e1e40; border-left-color: #ff4d4d; }
        .nav-link.active { color: #ff4d4d !important; background: #1e1e40; border-left-color: #ff4d4d; font-weight: 600; }
        .sidebar-divider { border-color: #2a2a50; margin: 8px 20px; }
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar { background: #10102a; border-bottom: 1px solid #2a2a50; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-title { font-size: 1.2rem; font-weight: 700; color: #f0f0f0; }
        .page-body { padding: 24px 28px; }
        .card { background: #10102a; border: 1px solid #2a2a50; border-radius: 14px; }
        .card-header { background: #1a1a38; border-bottom: 1px solid #2a2a50; border-radius: 14px 14px 0 0 !important; padding: 14px 20px; color: #f0f0f0; font-weight: 600; }
        .stat-card { background: linear-gradient(135deg, #10102a 0%, #1a1a38 100%); border: 1px solid #2a2a50; border-radius: 14px; padding: 20px; }
        .stat-card .stat-label { color: #8888aa; font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .stat-card .stat-value { font-size: 1.7rem; font-weight: 800; color: #ff4d4d; line-height: 1; }
        .stat-card .stat-value.green { color: #4cdf80; }
        .stat-card .stat-value.orange { color: #ff9800; }
        .stat-card .stat-value.blue { color: #4db8ff; }
        .stat-card .stat-value.gold { color: #f0a500; }
        .table { color: #e0e0f0; }
        .table thead th { background: #1a1a38; color: #aaaacc; border-color: #2a2a50; font-size: .82rem; text-transform: uppercase; letter-spacing: .5px; padding: 12px 16px; }
        .table td { border-color: #1e1e38; padding: 12px 16px; vertical-align: middle; color: #e0e0f0; }
        .table tbody tr:hover { background: #1a1a38; }
        .badge-pending   { background: #ff9800 !important; color: #000 !important; }
        .badge-approved  { background: #4cdf80 !important; color: #000 !important; }
        .badge-completed { background: #4cdf80 !important; color: #000 !important; }
        .badge-rejected  { background: #ff4d4d !important; color: #fff !important; }
        .badge-failed    { background: #ff4d4d !important; color: #fff !important; }
        .badge-processing{ background: #4db8ff !important; color: #000 !important; }
        .btn-primary { background: #f0a500; border-color: #f0a500; color: #000; font-weight: 700; }
        .btn-primary:hover { background: #d4920a; border-color: #d4920a; color: #000; }
        .btn-success { background: #4cdf80; border-color: #4cdf80; color: #000; font-weight: 600; }
        .btn-success:hover { background: #3bc96e; border-color: #3bc96e; color: #000; }
        .btn-danger { background: #ff4d4d; border-color: #ff4d4d; color: #fff; font-weight: 600; }
        .btn-danger:hover { background: #e03c3c; border-color: #e03c3c; }
        .btn-outline-secondary { border-color: #3a3a60; color: #b0b0cc; }
        .btn-outline-secondary:hover { background: #2a2a50; color: #f0f0f0; }
        .form-control, .form-select { background: #0a0a14; border: 1px solid #3a3a60; color: #f0f0f0; border-radius: 8px; }
        .form-control:focus, .form-select:focus { background: #0a0a14; border-color: #ff4d4d; color: #f0f0f0; box-shadow: 0 0 0 3px rgba(255,77,77,.15); }
        .form-control::placeholder { color: #5a5a80; }
        .form-label { color: #c0c0e0; font-weight: 500; font-size: .9rem; }
        .alert-success { background: #0d2a1a; border: 1px solid #4cdf80; color: #4cdf80; border-radius: 10px; }
        .alert-danger  { background: #2a0d0d; border: 1px solid #ff4d4d; color: #ff8080; border-radius: 10px; }
        .modal-content { background: #10102a; color: #f0f0f0; border: 1px solid #2a2a50; }
        .modal-header { border-color: #2a2a50; }
        .modal-footer { border-color: #2a2a50; }
        .text-muted { color: #7777aa !important; }
        .pagination .page-link { background: #10102a; border-color: #2a2a50; color: #b0b0cc; }
        .pagination .page-link:hover { background: #1e1e40; color: #ff4d4d; }
        .pagination .page-item.active .page-link { background: #ff4d4d; border-color: #ff4d4d; color: #fff; }
        .hamburger { display: none; background: none; border: none; color: #f0f0f0; font-size: 1.5rem; cursor: pointer; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 199; }
        .nav-dropdown-btn { color:#b0b0cc; padding:12px 22px; display:flex; align-items:center; gap:12px; font-size:.95rem; font-weight:500; border-left:3px solid transparent; transition:all .2s; cursor:pointer; background:none; border-top:none; border-right:none; border-bottom:none; width:100%; text-align:left; }
        .nav-dropdown-btn:hover { color:#f0f0f0; background:#1e1e40; border-left-color:#ff4d4d; }
        .nav-dropdown-btn.open { color:#ff4d4d; background:#1e1e40; border-left-color:#ff4d4d; }
        .nav-dropdown-btn .arrow { margin-left:auto; font-size:.75rem; transition:transform .2s; }
        .nav-dropdown-btn.open .arrow { transform:rotate(180deg); }
        .nav-sub { display:none; background:#060610; border-left:3px solid #ff4d4d; }
        .nav-sub.open { display:block; }
        .nav-sub .nav-link { padding:9px 22px 9px 44px; font-size:.88rem; border-left:none; }
        .nav-sub .nav-link:hover { background:#1a1a38; border-left:none; }
        .nav-sub .nav-link.active { color:#ff4d4d !important; background:#1a1a38; border-left:none; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .main-content { margin-left: 0; }
            .hamburger { display: block; }
            .page-body { padding: 16px; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">🛡️ Fast<span>Payz</span> Admin</div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.deposits.index') }}" class="nav-link {{ request()->routeIs('admin.deposits.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-circle-fill"></i> Deposits
        </a>
        <a href="{{ route('admin.withdrawals.index') }}" class="nav-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-up-circle-fill"></i> Withdrawals
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a>

        {{-- Reports Dropdown --}}
        @php $rOpen = request()->routeIs('admin.reports.*'); @endphp
        <button class="nav-dropdown-btn {{ $rOpen ? 'open':'' }}" onclick="toggleDD('rep')" id="repBtn">
            <i class="bi bi-bar-chart-fill" style="font-size:1.1rem;width:20px;"></i> Reports
            <i class="bi bi-chevron-down arrow"></i>
        </button>
        <div class="nav-sub {{ $rOpen ? 'open':'' }}" id="repSub">
            <a href="{{ route('admin.reports.finance') }}" class="nav-link {{ request()->routeIs('admin.reports.finance') ? 'active':'' }}">
                <i class="bi bi-graph-up-arrow"></i> Finance Report
            </a>
            <a href="{{ route('admin.reports.commissions') }}" class="nav-link {{ request()->routeIs('admin.reports.commissions') ? 'active':'' }}">
                <i class="bi bi-gem"></i> Commissions
            </a>
        </div>

        <a href="{{ route('admin.support.index') }}" class="nav-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
            <i class="bi bi-headset"></i> Support Tickets
        </a>
        <a href="{{ route('admin.chat.index') }}" class="nav-link {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots-fill"></i> Live Chat
        </a>
        <a href="{{ route('admin.payment.settings') }}" class="nav-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">
            <i class="bi bi-qr-code"></i> Payment Settings
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
        <div class="d-flex align-items-center gap-3">
            <button class="hamburger" onclick="openSidebar()"><i class="bi bi-list"></i></button>
            <div class="topbar-title">@yield('title')</div>
        </div>
        <small style="color:#7777aa;">Admin: <span style="color:#ff4d4d;">{{ auth()->user()->name }}</span></small>
    </div>

    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success mb-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-4"><i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openSidebar()  { document.getElementById('sidebar').classList.add('open'); document.getElementById('overlay').classList.add('open'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('open'); }
function toggleDD(n) { document.getElementById(n+'Btn').classList.toggle('open'); document.getElementById(n+'Sub').classList.toggle('open'); }
</script>
</body>
</html>
