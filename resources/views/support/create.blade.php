@extends('layouts.app')
@section('title', 'New Support Ticket')
@section('content')

<div class="row justify-content-center">
<div class="col-md-7">
<div class="card">
    <div class="card-header"><strong>🎧 Submit a Ticket</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('support.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label">Attachment <span class="text-muted">(optional)</span></label>
                <input type="file" name="attachment" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Submit Ticket</button>
        </form>
    </div>
</div>
</div>
</div>
@endsection
