@extends('layouts.admin')
@section('title', 'Manage Withdrawals')
@section('content')

{{-- Live Pool --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <span style="width:10px;height:10px;background:#4cdf80;border-radius:50%;display:inline-block;animation:blink 1.2s infinite;"></span>
        <span>Live Withdrawal Pool</span>
        <span class="ms-auto" style="color:#7777aa; font-size:.85rem;">{{ count($pool) }} active</span>
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
                    <th>Status</th>
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
                            {{ $w->method === 'upi' ? $w->upi_id : ($w->method === 'bank' ? $w->bank_account : '—') }}
                        </span>
                        @if($w->method === 'bank' && $w->bank_ifsc)
                        <br><span style="color:#7777aa; font-size:.78rem;">IFSC: {{ $w->bank_ifsc }}</span>
                        @endif
                        @if($w->method === 'qr' && $w->qr_screenshot)
                        <br>
                        <a href="{{ asset('storage/'.$w->qr_screenshot) }}" target="_blank">
                            <img src="{{ asset('storage/'.$w->qr_screenshot) }}" style="width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #2a2a50; margin-top:4px;">
                        </a>
                        @endif
                    </td>
                    <td>
                        @if($w->status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @else
                            <span class="badge badge-processing">Processing</span>
                        @endif
                    </td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $w->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            @if($w->status === 'pending')
                            <form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background:#4db8ff;border-color:#4db8ff;color:#000;">
                                    <i class="bi bi-hourglass-split"></i> Approve
                                </button>
                            </form>
                            @endif

                            {{-- Partial Payment Upload --}}
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#partialModal{{ $w->id }}">
                                <i class="bi bi-upload"></i> Upload Payment
                            </button>

                            @if($w->status === 'processing')
                            {{-- Finalize (complete karo jab sab confirm ho jaaye) --}}
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#finalizeModal{{ $w->id }}">
                                <i class="bi bi-check-all"></i> Finalize
                            </button>
                            @endif

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#failModal{{ $w->id }}">
                                <i class="bi bi-x-lg"></i> Fail
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Partial Upload Modal --}}
                <div class="modal fade" id="partialModal{{ $w->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-upload me-2" style="color:#ff9800;"></i>Upload Partial Payment — #{{ $w->id }} (₹{{ number_format($w->amount, 2) }})</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Pichle partial transactions --}}
                                @php $partials = $w->partialTransactions()->latest()->get(); $confirmedTotal = $partials->where('status','confirmed')->sum('amount'); $pendingTotal = $partials->where('status','pending')->sum('amount'); @endphp
                                @if($partials->count())
                                <div style="background:#1a1a38; border-radius:10px; padding:14px; margin-bottom:16px;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color:#aaa; font-size:.85rem;">Total Withdrawal</span>
                                        <span style="color:#ff4d4d; font-weight:700;">₹{{ number_format($w->amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color:#aaa; font-size:.85rem;">User ne Confirm kiya</span>
                                        <span style="color:#4cdf80; font-weight:700;">₹{{ number_format($confirmedTotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span style="color:#aaa; font-size:.85rem;">Pending Confirmation</span>
                                        <span style="color:#ff9800; font-weight:700;">₹{{ number_format($pendingTotal, 2) }}</span>
                                    </div>
                                </div>
                                <table class="table table-sm mb-3" style="font-size:.82rem;">
                                    <thead><tr><th>#</th><th>Amount</th><th>UTR</th><th>Screenshot</th><th>Status</th><th>Time</th></tr></thead>
                                    <tbody>
                                    @foreach($partials as $pt)
                                    <tr>
                                        <td style="color:#7777aa;">{{ $loop->iteration }}</td>
                                        <td style="color:#f0a500; font-weight:600;">₹{{ number_format($pt->amount, 2) }}</td>
                                        <td style="font-family:monospace; color:#c0c0e0;">{{ $pt->utr_number ?? '—' }}</td>
                                        <td>
                                            @if($pt->proof_screenshot)
                                            <a href="{{ asset('storage/'.$pt->proof_screenshot) }}" target="_blank"><i class="bi bi-image" style="color:#4cdf80;"></i></a>
                                            @else —
                                            @endif
                                        </td>
                                        <td>
                                            @if($pt->status === 'confirmed')
                                            <span class="badge" style="background:#4cdf80; color:#000;">Confirmed ✓</span>
                                            @else
                                            <span class="badge" style="background:#ff9800; color:#000;">User Pending</span>
                                            @endif
                                        </td>
                                        <td style="color:#7777aa;">{{ $pt->created_at->format('d M, h:i A') }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif

                                {{-- New partial upload form --}}
                                <form method="POST" action="{{ route('admin.withdrawals.upload.partial', $w) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div style="border-top: 1px solid #2a2a50; padding-top:14px;">
                                        <p style="color:#aaa; font-size:.85rem; margin-bottom:12px;"><i class="bi bi-plus-circle me-1" style="color:#ff9800;"></i>Naya partial payment upload karo</p>
                                        <div class="row g-2 mb-2">
                                            <div class="col-6">
                                                <label class="form-label" style="font-size:.82rem;">Amount (₹)</label>
                                                <input type="number" name="amount" class="form-control" placeholder="e.g. 10000" min="1" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" style="font-size:.82rem;">UTR Number</label>
                                                <input type="text" name="utr_number" class="form-control" placeholder="UTR / Ref no.">
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label" style="font-size:.82rem;">Payment Screenshot</label>
                                            <input type="file" name="proof_screenshot" class="form-control" accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" style="font-size:.82rem;">Note (optional)</label>
                                            <input type="text" name="note" class="form-control" placeholder="e.g. 1st installment">
                                        </div>
                                        <button type="submit" class="btn btn-warning w-100"><i class="bi bi-upload me-1"></i>Upload Partial Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Finalize Modal --}}
                <div class="modal fade" id="finalizeModal{{ $w->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-check-all me-2" style="color:#4cdf80;"></i>Finalize Withdrawal #{{ $w->id }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.withdrawals.finalize', $w) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div style="background:#0d2a0d; border:1px solid #4cdf80; border-radius:10px; padding:12px; margin-bottom:14px; font-size:.85rem; color:#90ee90;">
                                        <i class="bi bi-info-circle me-1"></i> Sab partial payments user ne confirm kar diye hain tab hi finalize hoga. Ye withdrawal fully complete ho jaayega.
                                    </div>
                                    <label class="form-label">Final UTR / Summary Reference <span style="color:#7777aa;">(optional)</span></label>
                                    <input type="text" name="utr_number" class="form-control mb-3" placeholder="Final UTR or summary note">
                                    <label class="form-label">Final Summary Screenshot <span style="color:#7777aa;">(optional)</span></label>
                                    <input type="file" name="proof_screenshot" class="form-control" accept="image/*">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-check-all me-1"></i>Mark Fully Complete</button>
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
                    <td colspan="7" class="text-center py-5">
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
                <tr><th>#</th><th>User</th><th>Amount</th><th>Method</th><th>UTR</th><th>Status</th><th>Date</th><th>Receipt</th></tr>
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
                    <td>
                        @if($w->status === 'completed')
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.withdrawals.receipt', $w) }}" target="_blank" class="btn btn-sm" style="background:#1a1a38;border:1px solid #3a3a60;color:#4cdf80;font-size:.78rem;">
                                <i class="bi bi-file-earmark-text"></i> Receipt
                            </a>
                        </div>
                        @else
                        <span style="color:#3a3a60;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No withdrawals yet</td></tr>
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
