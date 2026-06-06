<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastpayoutX - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0d0d1a; color: #f0f0f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .auth-wrap { width: 100%; max-width: 440px; padding: 20px; }
        .auth-card { background: #13132b; border: 1px solid #2a2a50; border-radius: 20px; padding: 40px 36px; }
        .brand { font-size: 2.2rem; font-weight: 800; color: #f0a500; text-align: center; margin-bottom: 4px; }
        .brand span { color: #ffffff; }
        .subtitle { text-align: center; color: #7777aa; font-size: .9rem; margin-bottom: 28px; }
        .form-label { color: #c0c0e0; font-weight: 500; font-size: .9rem; }
        .form-control { background: #0d0d1a; border: 1px solid #3a3a60; color: #f0f0f0; border-radius: 10px; padding: 12px 14px; }
        .form-control:focus { background: #0d0d1a; border-color: #f0a500; color: #f0f0f0; box-shadow: 0 0 0 3px rgba(240,165,0,.15); }
        .form-control::placeholder { color: #4a4a70; }
        .btn-primary { background: #f0a500; border-color: #f0a500; color: #000; font-weight: 700; width: 100%; padding: 12px; border-radius: 10px; font-size: 1rem; }
        .btn-primary:hover { background: #d4920a; border-color: #d4920a; color: #000; }
        .alert-danger { background: #2a0d0d; border: 1px solid #ff4d4d; color: #ff8080; border-radius: 10px; font-size: .9rem; }
        a { color: #f0a500; text-decoration: none; }
        a:hover { color: #d4920a; }
        .divider { border-color: #2a2a50; margin: 20px 0; }
        .step-badge { background: #f0a500; color: #000; border-radius: 50%; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; margin-right: 8px; }
        .app-download { display: none; background: #0d0d1a; border: 1px solid #2a2a50; border-radius: 14px; padding: 16px; margin-top: 20px; text-align: center; }
        .app-download p { color: #7777aa; font-size: .8rem; margin-bottom: 10px; }
        .app-btn { display: inline-flex; align-items: center; gap: 6px; background: #1a1a35; border: 1px solid #3a3a60; border-radius: 8px; padding: 5px 12px; color: #c0c0e0; text-decoration: none; font-size: .78rem; transition: border-color .2s; }
        .app-btn:hover { border-color: #f0a500; color: #f0a500; text-decoration: none; }
        .app-btn i { font-size: .95rem; }
        @media (max-width: 768px) { .app-download { display: block; } }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="brand"><img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastpayoutX" style="height:64px; width:auto;"></div>
        <div class="subtitle">Create your account</div>

        <div class="d-flex justify-content-center gap-2 mb-4">
            <span style="color:#f0a500; font-size:.8rem; font-weight:600;">① Mobile</span>
            <span style="color:#3a3a60;">→</span>
            <span style="color:#5a5a80; font-size:.8rem;">② OTP</span>
            <span style="color:#3a3a60;">→</span>
            <span style="color:#5a5a80; font-size:.8rem;">③ Details</span>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $e)<div><i class="bi bi-x-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.otp') }}">
            @csrf
            <input type="hidden" name="ref_code" value="{{ $refCode ?? '' }}">
            <div class="mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email address" value="{{ old('email') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP <i class="bi bi-arrow-right ms-1"></i></button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="color:#7777aa; font-size:.9rem;">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>

        <div class="app-download">
            <p><i class="bi bi-phone"></i> Download Our App</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="{{ asset('app.apk') }}" class="app-btn" download><i class="bi bi-download"></i> Download APK</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
