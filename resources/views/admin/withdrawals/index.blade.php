@extends('layouts.admin')
@section('title', 'Manage Withdrawals')
@section('content')

{{-- Live Pool --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <span style="width:10px;height:10px;background:#4cdf80;border-radius:50%;display:inline-block;animation:blink 1.2s infinite;"></span>
        <span>Live Withdrawal Pool</span>
        <span class="ms-auto" style="color:#7777aa; font-size:.85rem;">{{ count($pool) }} pending</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method & Details</th>
                    <th>Requested</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pool as $w)
                <tr>
                    <td style="color:#7777aa;">{{ $w->id }}</td>
                    <td>
                        <div style="color:#f0f0f0; font-weight:600;">{{ $w->user->name }}</div>
                        <div style="color:#7777aa; font-size:.8rem;">{{ $w->user->mobile }}</div>
                    </td>
                    <td style="color:#ff4d4d; font-weight:700; font-size:1rem;">₹{{ number_format($w->amount, 2) }}</td>
                    <td>
                        <span class="badge bg-secondary mb-1">{{ strtoupper($w->method) }}</span><br>
                        <span style="color:#c0c0e0; font-size:.82rem; font-family:monospace;">
                            {{ $w->method === 'upi' ? $w->upi_id : $w->bank_account }}
                        </span>
                        @if($w->method === 'bank' && $w->bank_ifsc)
                        <br><span style="color:#7777aa; font-size:.78rem;">IFSC: {{ $w->bank_ifsc }}</span>
                        @endif
                    </td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $w->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#doneModal{{ $w->id }}">
                                <i class="bi bi-check-lg"></i> Done
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#failModal{{ $w->id }}">
                                <i class="bi bi-x-lg"></i> Fail
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Complete Modal --}}
                <div class="modal fade" id="doneModal{{ $w->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2" style="color:#4cdf80;"></i>Complete Withdrawal #{{ $w->id }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.withdrawals.complete', $w) }}">
                                @csrf
                                <div class="modal-body">
                                    <div style="background:#1a1a38; border-radius:10px; padding:14px; margin-bottom:16px;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="color:#7777aa; font-size:.85rem;">User</span>
                                            <span style="color:#f0f0f0; font-weight:600;">{{ $w->user->name }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="color:#7777aa; font-size:.85rem;">Amount</span>
                                            <span style="color:#ff4d4d; font-weight:700;">₹{{ number_format($w->amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style="color:#7777aa; font-size:.85rem;">{{ strtoupper($w->method) }}</span>
                                            <span style="color:#c0c0e0; font-size:.85rem; font-family:monospace;">{{ $w->method === 'upi' ? $w->upi_id : $w->bank_account }}</span>
                                        </div>
                                    </div>
                                    <label class="form-label">UTR Number <span style="color:#ff4d4d;">*</span></label>
                                    <input type="text" name="utr_number" class="form-control" placeholder="Enter UTR after sending money" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Mark Complete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Fail Modal --}}
                <div class="modal fade" id="failModal{{ $w->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-x-circle-fill me-2" style="color:#ff4d4d;"></i>Fail Withdrawal #{{ $w->id }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.withdrawals.fail', $w) }}">
                                @csrf
                                <div class="modal-body">
                                    <div style="background:#2a0d0d; border:1px solid #ff4d4d; border-radius:10px; padding:12px; margin-bottom:14px;">
                                        <div style="color:#ff8080; font-size:.85rem;"><i class="bi bi-exclamation-triangle me-1"></i>Amount ₹{{ number_format($w->amount, 2) }} will be refunded to user's wallet.</div>
                                    </div>
                                    <label class="form-label">Reason for Failure</label>
                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="Enter reason..." required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-1"></i>Mark Failed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div style="font-size:2.5rem;">✅</div>
                        <div class="text-muted mt-2">Pool is empty - all processed</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- All Withdrawals History --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📋 Withdrawal History</span>
        <span style="color:#7777aa; font-size:.85rem;">Total: {{ $withdrawals->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>User</th><th>Amount</th><th>Method</th><th>UTR</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $w)
                <tr>
                    <td style="color:#7777aa;">{{ $w->id }}</td>
                    <td>
                        <div style="color:#f0f0f0; font-weight:500;">{{ $w->user->name }}</div>
                        <div style="color:#7777aa; font-size:.8rem;">{{ $w->user->mobile }}</div>
                    </td>
                    <td style="color:#ff4d4d; font-weight:700;">₹{{ number_format($w->amount, 2) }}</td>
                    <td><span class="badge bg-secondary">{{ strtoupper($w->method) }}</span></td>
                    <td style="color:#c0c0e0; font-family:monospace; font-size:.85rem;">{{ $w->utr_number ?? '—' }}</td>
                    <td><span class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span></td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $w->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No withdrawals yet</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $withdrawals->links() }}</div>

@endsection
@section('scripts')
<style>
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
</style>
@endsection
