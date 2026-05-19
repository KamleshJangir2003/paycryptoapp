<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastPayz - Complete Registration</title>
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
        .optional-label { color: #5a5a80; font-size: .8rem; font-weight: 400; }
        .referral-box { background: #0d0d1a; border: 1px dashed #3a3a60; border-radius: 10px; padding: 14px; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="brand">⚡ Fast<span>Payz</span></div>
        <div class="subtitle">Complete your profile</div>

        <div class="d-flex justify-content-center gap-2 mb-4">
            <span style="color:#5a5a80; font-size:.8rem;">① Mobile</span>
            <span style="color:#3a3a60;">→</span>
            <span style="color:#5a5a80; font-size:.8rem;">② OTP</span>
            <span style="color:#3a3a60;">→</span>
            <span style="color:#f0a500; font-size:.8rem; font-weight:600;">③ Details</span>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $e)<div><i class="bi bi-x-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.complete.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
            </div>
            <div class="mb-4 referral-box">
                <label class="form-label">Referral Code <span class="optional-label">(optional)</span></label>
                <input type="text" name="referral_code" class="form-control" placeholder="Enter referral code to earn bonus"
                    value="{{ old('referral_code', session('reg_ref')) }}" style="background:#13132b;">
                <div style="color:#5a5a80; font-size:.8rem; margin-top:6px;"><i class="bi bi-gift me-1"></i>Get bonus commission when you use a referral code</div>
            </div>
            <button type="submit" class="btn btn-primary">Create Account <i class="bi bi-check-circle ms-1"></i></button>
        </form>
    </div>
</div>
</body>
</html>
