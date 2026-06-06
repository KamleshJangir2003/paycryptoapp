<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastpayoutX - Admin Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0a0a0a; color: #f0f0f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .auth-wrap { width: 100%; max-width: 440px; padding: 20px; }
        .auth-card { background: #111; border: 1px solid #ff4444; border-radius: 20px; padding: 40px 36px; }
        .form-label { color: #c0c0c0; font-weight: 500; font-size: .9rem; }
        .form-control { background: #0a0a0a; border: 1px solid #333; color: #f0f0f0; border-radius: 10px; padding: 12px 14px; }
        .form-control:focus { background: #0a0a0a; border-color: #ff4444; color: #f0f0f0; box-shadow: 0 0 0 3px rgba(255,68,68,.15); }
        .form-control::placeholder { color: #444; }
        .btn-danger { background: #ff4444; border-color: #ff4444; color: #fff; font-weight: 700; width: 100%; padding: 12px; border-radius: 10px; font-size: 1rem; }
        .btn-danger:hover { background: #cc0000; border-color: #cc0000; }
        .alert-danger { background: #2a0d0d; border: 1px solid #ff4d4d; color: #ff8080; border-radius: 10px; font-size: .9rem; }
        .badge-admin { background: #ff4444; color: #fff; font-size: .75rem; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 16px; }
        a { color: #ff4444; text-decoration: none; }
        a:hover { color: #cc0000; text-decoration: underline; }
        .divider { border-color: #333; margin: 20px 0; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="text-center"><img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastpayoutX" style="height:64px;width:auto;"></div>
        <div class="text-center mt-2"><span class="badge-admin"><i class="bi bi-shield-lock me-1"></i>Admin Panel</span></div>
        <h5 style="color:#f0f0f0;font-weight:700;text-align:center;margin-bottom:6px;">Reset Password</h5>
        <p style="color:#888;font-size:.88rem;text-align:center;margin-bottom:24px;">Enter the OTP sent to your email and set a new password.</p>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $e)<div><i class="bi bi-x-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.reset') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">OTP Code</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter 6-digit OTP" maxlength="6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="btn btn-danger"><i class="bi bi-key-fill me-2"></i>Reset Password</button>
        </form>

        <hr class="divider">
        <p class="text-center mb-0" style="color:#888;font-size:.9rem;">
            <a href="{{ route('admin.login') }}"><i class="bi bi-arrow-left me-1"></i>Back to Admin Login</a>
        </p>
    </div>
</div>
</body>
</html>
