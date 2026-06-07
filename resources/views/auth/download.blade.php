<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastpayoutX - Download App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0d0d1a; color: #f0f0f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .wrap { width: 100%; max-width: 440px; padding: 20px; }
        .card-box { background: #13132b; border: 1px solid #2a2a50; border-radius: 20px; padding: 40px 36px; text-align: center; }
        .btn-download { background: #f0a500; border-color: #f0a500; color: #000; font-weight: 700; width: 100%; padding: 14px; border-radius: 10px; font-size: 1rem; border: none; }
        .btn-download:hover { background: #d4920a; }
        .btn-skip { background: none; border: 1px solid #3a3a60; color: #7777aa; width: 100%; padding: 10px; border-radius: 10px; font-size: .9rem; margin-top: 12px; }
        .btn-skip:hover { border-color: #f0a500; color: #f0a500; }
        .step { background: #0d0d1a; border: 1px solid #2a2a50; border-radius: 12px; padding: 12px 16px; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; text-align: left; }
        .step-num { background: #f0a500; color: #000; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .8rem; flex-shrink: 0; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card-box">
        <img src="{{ asset('logonew-removebg-preview.png') }}" alt="FastpayoutX" style="height:64px; width:auto; margin-bottom:16px;">

        <div style="font-size:1.3rem; font-weight:800; color:#f0a500; margin-bottom:6px;">Registration Successful! 🎉</div>
        <div style="color:#7777aa; font-size:.88rem; margin-bottom:28px;">Download our app and login to get started</div>

        <div class="mb-4">
            <div class="step">
                <div class="step-num">1</div>
                <div style="font-size:.85rem; color:#c0c0e0;">Download & install the APK on your phone</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div style="font-size:.85rem; color:#c0c0e0;">Open the app and login with your credentials</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div style="font-size:.85rem; color:#c0c0e0;">Start earning!</div>
            </div>
        </div>

        <a href="{{ asset('fastpayoutx.apk') }}" download class="btn btn-download">
            <i class="bi bi-download me-2"></i>Download APK
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-skip">
            Skip for now, go to Dashboard
        </a>
    </div>
</div>
</body>
</html>
