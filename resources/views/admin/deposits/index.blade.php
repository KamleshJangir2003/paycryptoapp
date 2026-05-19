@extends('layouts.admin')
@section('title', 'Manage Deposits')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📥 All Deposit Requests</span>
        <span style="color:#7777aa; font-size:.85rem;">Total: {{ $deposits->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>UTR Number</th>
                    <th>Screenshot</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deposits as $d)
                <tr>
                    <td style="color:#7777aa;">{{ $d->id }}</td>
                    <td>
                        <div style="color:#f0f0f0; font-weight:600;">{{ $d->user->name }}</div>
                        <div style="color:#7777aa; font-size:.8rem;">{{ $d->user->mobile }}</div>
                    </td>
                    <td style="color:#f0a500; font-weight:700; font-size:1rem;">₹{{ number_format($d->amount, 2) }}</td>
                    <td style="color:#c0c0e0; font-family:monospace; font-size:.88rem;">{{ $d->utr_number ?? '—' }}</td>
                    <td>
                        @if($d->screenshot)
                        <a href="{{ asset('storage/'.$d->screenshot) }}" target="_blank"
                            class="btn btn-sm" style="background:#1a1a38; color:#4db8ff; border:1px solid #2a2a50;">
                            <i class="bi bi-image me-1"></i>View
                        </a>
                        @else
                        <span style="color:#5a5a80; font-size:.82rem;">No file</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $d->status }}">{{ ucfirst($d->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $d->created_at->format('d M Y') }}<br>{{ $d->created_at->format('h:i A') }}</td>
                    <td>
                        @if($d->status === 'pending')
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('admin.deposits.approve', $d) }}">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                            </form>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $d->id }}">
                                <i class="bi bi-x-lg"></i> Reject
                            </button>
                        </div>
                        @elseif($d->status === 'approved')
                        <span style="color:#4cdf80; font-size:.85rem;"><i class="bi bi-check-circle-fill me-1"></i>Approved</span>
                        @else
                        <span style="color:#ff4d4d; font-size:.85rem;"><i class="bi bi-x-circle-fill me-1"></i>Rejected</span>
                        @endif
                    </td>
                </tr>

                {{-- Reject Modal --}}
                @if($d->status === 'pending')
                <div class="modal fade" id="rejectModal{{ $d->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Deposit #{{ $d->id }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.deposits.reject', $d) }}">
                                @csrf
                                <div class="modal-body">
                                    <div style="background:#1a1a38; border-radius:10px; padding:12px; margin-bottom:14px;">
                                        <div style="color:#7777aa; font-size:.82rem;">User: <span style="color:#f0f0f0;">{{ $d->user->name }}</span></div>
                                        <div style="color:#7777aa; font-size:.82rem;">Amount: <span style="color:#f0a500; font-weight:700;">₹{{ number_format($d->amount, 2) }}</span></div>
                                    </div>
                                    <label class="form-label">Reason for Rejection</label>
                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="Enter reason..." required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-1"></i>Reject</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div style="font-size:2.5rem;">📭</div>
                        <div class="text-muted mt-2">No deposit requests</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $deposits->links() }}</div>

@endsection
