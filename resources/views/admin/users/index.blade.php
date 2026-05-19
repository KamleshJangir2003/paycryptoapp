@extends('layouts.admin')
@section('title', 'Manage Users')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>👥 All Users</span>
        <span style="color:#7777aa; font-size:.85rem;">Total: {{ $users->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Main Wallet</th>
                    <th>Earnings</th>
                    <th>Referrals</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td style="color:#7777aa;">{{ $u->id }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $u) }}" style="color:#4db8ff; font-weight:600; text-decoration:none;">
                            {{ $u->name }}
                        </a>
                        <div style="color:#5a5a80; font-size:.78rem; font-family:monospace;">{{ $u->referral_code }}</div>
                    </td>
                    <td style="color:#c0c0e0; font-family:monospace;">{{ $u->mobile }}</td>
                    <td style="color:#f0a500; font-weight:600;">₹{{ number_format($u->wallet->main_balance ?? 0, 2) }}</td>
                    <td style="color:#4cdf80; font-weight:600;">₹{{ number_format($u->wallet->earnings_balance ?? 0, 2) }}</td>
                    <td style="color:#4db8ff;">{{ $u->referrals_count ?? 0 }}</td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $u->created_at->format('d M Y') }}</td>
                    <td>
                        @if($u->is_active)
                        <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">Active</span>
                        @else
                        <span class="badge" style="background:#2a0d0d; color:#ff4d4d; border:1px solid #ff4d4d;">Disabled</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                            @csrf
                            <button class="btn btn-sm {{ $u->is_active ? 'btn-danger' : 'btn-success' }}">
                                {{ $u->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div style="font-size:2.5rem;">👥</div>
                        <div class="text-muted mt-2">No users registered yet</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>

@endsection
