@extends('layouts.app')
@section('title', 'Change Password')
@section('content')

<div class="row justify-content-center">
<div class="col-12 col-md-6 col-lg-5">
    <div class="card">
        <div class="card-header">🔒 Change Password</div>
        <div class="card-body">

            <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:20px;">
                <div style="color:#7777aa; font-size:.85rem;">
                    <i class="bi bi-shield-check me-2" style="color:#4cdf80;"></i>
                    Strong password tips:<br>
                    <span style="color:#5a5a80; font-size:.8rem;">• Minimum 6 characters<br>• Mix of letters and numbers<br>• Avoid using mobile number as password</span>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.password') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control"
                        placeholder="Enter your current password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Minimum 6 characters" required id="newPass">
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Re-enter new password" required id="confirmPass">
                    <div id="matchMsg" style="font-size:.8rem; margin-top:4px; display:none;"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-shield-lock-fill me-2"></i>Update Password
                </button>
            </form>
        </div>
    </div>
</div>
</div>

@endsection
@section('scripts')
<script>
document.getElementById('confirmPass').addEventListener('input', function() {
    const msg = document.getElementById('matchMsg');
    if (this.value === document.getElementById('newPass').value) {
        msg.style.display = 'block';
        msg.style.color = '#4cdf80';
        msg.innerHTML = '<i class="bi bi-check-circle me-1"></i>Passwords match';
    } else {
        msg.style.display = 'block';
        msg.style.color = '#ff4d4d';
        msg.innerHTML = '<i class="bi bi-x-circle me-1"></i>Passwords do not match';
    }
});
</script>
@endsection
