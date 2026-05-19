@extends('layouts.admin')
@section('title', 'Support Tickets')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-4">
        <div class="stat-card text-center">
            <div class="stat-label">🔴 Open</div>
            <div class="stat-value" style="color:#ff9800;">{{ $stats['open'] }}</div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card text-center">
            <div class="stat-label">🟢 Replied</div>
            <div class="stat-value green">{{ $stats['replied'] }}</div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card text-center">
            <div class="stat-label">⚫ Closed</div>
            <div class="stat-value" style="color:#7777aa;">{{ $stats['closed'] }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>🎫 All Support Tickets</span>
        <span style="color:#7777aa; font-size:.85rem;">Total: {{ $tickets->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>User</th><th>Subject</th><th>Message</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td style="color:#7777aa;">{{ $t->id }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $t->user) }}" style="color:#4db8ff; text-decoration:none; font-weight:500; font-size:.88rem;">{{ $t->user->name }}</a>
                        <div style="color:#7777aa; font-size:.78rem;">{{ $t->user->mobile }}</div>
                    </td>
                    <td style="color:#f0f0f0; font-weight:500; font-size:.88rem;">{{ $t->subject }}</td>
                    <td style="color:#8888aa; font-size:.82rem; max-width:160px;">{{ \Str::limit($t->message, 50) }}</td>
                    <td>
                        @if($t->status === 'open')
                            <span class="badge" style="background:#2a1a0d; color:#ff9800; border:1px solid #ff9800;">● Open</span>
                        @elseif($t->status === 'replied')
                            <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">● Replied</span>
                        @else
                            <span class="badge" style="background:#1a1a38; color:#7777aa; border:1px solid #3a3a60;">● Closed</span>
                        @endif
                    </td>
                    <td style="color:#7777aa; font-size:.8rem;">{{ $t->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $t->id }}">
                                <i class="bi bi-reply-fill"></i>
                            </button>
                            @if($t->status !== 'closed')
                            <form method="POST" action="{{ route('admin.support.close', $t) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" title="Close Ticket">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- Reply Modal --}}
                <div class="modal fade" id="replyModal{{ $t->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">🎫 Ticket #{{ $t->id }} - {{ $t->subject }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                {{-- User Info --}}
                                <div style="background:#1a1a38; border-radius:10px; padding:12px; margin-bottom:14px;">
                                    <div style="color:#7777aa; font-size:.8rem;">From: <span style="color:#f0f0f0; font-weight:600;">{{ $t->user->name }}</span> ({{ $t->user->mobile }})</div>
                                    <div style="color:#7777aa; font-size:.8rem; margin-top:2px;">Date: {{ $t->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                {{-- User Message --}}
                                <div style="background:#0d0d1a; border:1px solid #2a2a50; border-radius:10px; padding:14px; margin-bottom:14px;">
                                    <div style="color:#8888aa; font-size:.78rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">User Message</div>
                                    <div style="color:#c0c0e0; font-size:.9rem; line-height:1.6;">{{ $t->message }}</div>
                                </div>
                                {{-- Previous Reply --}}
                                @if($t->admin_reply)
                                <div style="background:#0d2a1a; border:1px solid #4cdf80; border-radius:10px; padding:14px; margin-bottom:14px;">
                                    <div style="color:#4cdf80; font-size:.78rem; font-weight:600; text-transform:uppercase; margin-bottom:6px;">Previous Reply</div>
                                    <div style="color:#c0c0e0; font-size:.9rem; line-height:1.6;">{{ $t->admin_reply }}</div>
                                </div>
                                @endif
                                {{-- Reply Form --}}
                                <form method="POST" action="{{ route('admin.support.reply', $t) }}">
                                    @csrf
                                    <label class="form-label">Your Reply</label>
                                    <textarea name="admin_reply" class="form-control" rows="4"
                                        placeholder="Type your reply here..." required>{{ $t->admin_reply }}</textarea>
                                    <div class="mt-3 d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send-fill me-1"></i>Send Reply
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="font-size:2.5rem;">🎫</div>
                        <div class="text-muted mt-2">No support tickets</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $tickets->links() }}</div>

@endsection
