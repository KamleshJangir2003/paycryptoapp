@extends('layouts.app')
@section('title', 'Support')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div style="color:#8888aa; font-size:.9rem;">Submit a ticket for any issue</div>
    <a href="{{ route('support.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> New Ticket
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>🎫 My Support Tickets</span>
        <span style="color:#7777aa; font-size:.85rem;">{{ $tickets->total() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Admin Reply</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td style="color:#7777aa;">{{ $t->id }}</td>
                    <td style="color:#f0f0f0; font-weight:500;">{{ $t->subject }}</td>
                    <td>
                        @if($t->status === 'open')
                            <span class="badge" style="background:#1a1a0d; color:#ff9800; border:1px solid #ff9800;">● Open</span>
                        @elseif($t->status === 'replied')
                            <span class="badge" style="background:#0d2a1a; color:#4cdf80; border:1px solid #4cdf80;">● Replied</span>
                        @else
                            <span class="badge" style="background:#1a1a38; color:#7777aa; border:1px solid #3a3a60;">● Closed</span>
                        @endif
                    </td>
                    <td style="color:#8888aa; font-size:.85rem; max-width:200px;">
                        {{ $t->admin_reply ? \Str::limit($t->admin_reply, 50) : '—' }}
                    </td>
                    <td style="color:#7777aa; font-size:.82rem;">{{ $t->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="font-size:2.5rem;">🎫</div>
                        <div class="text-muted mt-2">No tickets yet</div>
                        <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm mt-3">Create First Ticket</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $tickets->links() }}</div>

{{-- Quick Help Links --}}
<div class="row g-3 mt-2">
    <div class="col-6 col-md-3">
        <a href="{{ route('faq') }}" class="card p-3 text-decoration-none text-center d-block">
            <div style="font-size:1.8rem;">❓</div>
            <div style="color:#f0a500; font-weight:600; margin-top:4px; font-size:.9rem;">FAQ</div>
            <div style="color:#7777aa; font-size:.78rem;">Common questions</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('tutorial') }}" class="card p-3 text-decoration-none text-center d-block">
            <div style="font-size:1.8rem;">📖</div>
            <div style="color:#f0a500; font-weight:600; margin-top:4px; font-size:.9rem;">Tutorial</div>
            <div style="color:#7777aa; font-size:.78rem;">Step by step guide</div>
        </a>
    </div>
</div>

@endsection
