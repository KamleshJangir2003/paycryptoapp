<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastpayoutX - Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0d0d1a; color: #f0f0f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .auth-wrap { width: 100%; max-width: 440px; padding: 20px; }
        .auth-card { background: #13132b; border: 1px solid #2a2a50; border-radius: 20px; padding: 40px 36px; }
        .form-label { color: #c0c0e0; font-weight: 500; font-size: .9rem; }
        .form-control { background: #0d0d1a; border: 1px solid #3a3a60; color: #f0f0f0; border-radius: 10px; padding: 12px 14px; }
        .form-control:focus { background: #0d0d1a; border-color: #f0a500; color: #f0f0f0; box-shadow: 0 0 0 3px rgba(240,165,0,.15); }
        .form-control::placeholder { color: #4a4a70; }
        .btn-primary { background: #f0a500; border-color: #f0a500; color: #000; font-weight: 700; width: 100%; padding: 12px; border-radius: 10px; font-size: 1rem; }
        .btn-primary:hover { background: #d4920a; border-color: #d4920a; color: #000; }
        .alert-danger { background: #2a0d0d; border: 1px solid #ff4d4d; color: #ff8080; border-radius: 10px; font-size: .9rem; }
        a { color: #f0a500; text-decoration: none; }
        a:hover { color: #d4920a; text-decoration: underline; }
        .divider { border-color: #2a2a50; margin: 20px 0; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastpayoutX" style="height:64px;width:auto;">
        </div>
        <h5 style="color:#f0f0f0;font-weight:700;text-align:center;margin-bottom:6px;">Forgot Password?</h5>
        <p style="color:#7777aa;font-size:.88rem;text-align:center;margin-bottom:24px;">Enter your registered email. We'll send an OTP to reset your password.</p>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $e)<div><i class="bi bi-x-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.forgot.send') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your registered email" value="{{ old('email') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send-fill me-2"></i>Send OTP
            </button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="color:#7777aa;font-size:.9rem;">
            Remember password? <a href="{{ route('login') }}">Login here</a>
        </p>
    </div>
</div>
</body>
</html>
