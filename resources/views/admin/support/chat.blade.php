@extends('layouts.admin')
@section('title', 'Support Chat')
@section('content')

<div style="height:calc(100vh - 130px); display:flex; border:1px solid #2a2a50; border-radius:14px; overflow:hidden; background:#0a0a14;">

    {{-- LEFT: User List --}}
    <div style="width:300px; flex-shrink:0; background:#10102a; border-right:1px solid #2a2a50; display:flex; flex-direction:column;">

        <div style="padding:16px; border-bottom:1px solid #2a2a50;">
            <div style="color:#f0f0f0; font-weight:700; font-size:1rem;">💬 Support Chats</div>
            @if($totalUnread > 0)
            <div style="color:#ff9800; font-size:.8rem; margin-top:2px;">{{ $totalUnread }} unread messages</div>
            @endif
        </div>

        <div style="flex:1; overflow-y:auto;">
            @forelse($users as $u)
            @php $lastMsg = $u->chatMessages->first(); @endphp
            <a href="{{ route('admin.chat.show', $u) }}"
                style="display:flex; align-items:center; gap:12px; padding:14px 16px; text-decoration:none; border-bottom:1px solid #1a1a38; transition:background .15s;
                background:{{ isset($user) && $user->id === $u->id ? '#1e1e40' : 'transparent' }};"
                onmouseover="this.style.background='#1a1a38'" onmouseout="this.style.background='{{ isset($user) && $user->id === $u->id ? '#1e1e40' : 'transparent' }}'">

                <div style="width:44px; height:44px; background:#2a2a50; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; position:relative;">
                    👤
                    @if($u->unread > 0)
                    <span style="position:absolute; top:-2px; right:-2px; background:#4cdf80; color:#000; border-radius:50%; width:18px; height:18px; font-size:.65rem; font-weight:800; display:flex; align-items:center; justify-content:center;">{{ $u->unread }}</span>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="color:#f0f0f0; font-weight:600; font-size:.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->name }}</div>
                    <div style="color:#7777aa; font-size:.78rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        @if($lastMsg)
                            {{ $lastMsg->sender === 'admin' ? 'You: ' : '' }}{{ \Str::limit($lastMsg->message ?: '📎 Attachment', 30) }}
                        @endif
                    </div>
                </div>
                @if($lastMsg)
                <div style="color:#7777aa; font-size:.7rem; flex-shrink:0;">{{ $lastMsg->created_at->format('h:i A') }}</div>
                @endif
            </a>
            @empty
            <div style="text-align:center; padding:40px 20px; color:#5a5a80;">
                <div style="font-size:2rem; margin-bottom:8px;">💬</div>
                <div style="font-size:.85rem;">No chats yet</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT: Chat Area --}}
    @if(isset($user))
    <div style="flex:1; display:flex; flex-direction:column; background:#0a0a14;">

        {{-- Chat Header --}}
        <div style="background:#10102a; padding:14px 20px; border-bottom:1px solid #2a2a50; display:flex; align-items:center; gap:12px;">
            <div style="width:42px; height:42px; background:#2a2a50; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">👤</div>
            <div>
                <div style="color:#f0f0f0; font-weight:700; font-size:.95rem;">{{ $user->name }}</div>
                <div style="color:#7777aa; font-size:.78rem;">{{ $user->mobile }}</div>
            </div>
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary ms-auto" style="font-size:.78rem;">
                <i class="bi bi-person-fill me-1"></i>View Profile
            </a>
        </div>

        {{-- Messages --}}
        <div id="chatBox" style="flex:1; overflow-y:auto; padding:16px; display:flex; flex-direction:column; gap:8px;">

            <div data-welcome style="text-align:center; margin:10px 0;">
                <span style="background:#1a1a38; color:#7777aa; font-size:.75rem; padding:5px 14px; border-radius:20px;">
                    Chat with {{ $user->name }}
                </span>
            </div>

            @foreach($messages as $msg)
            @if($msg->sender === 'admin')
            {{-- Admin message - right --}}
            <div style="display:flex; justify-content:flex-end;">
                <div style="max-width:65%; background:#005c4b; border-radius:12px 12px 2px 12px; padding:10px 14px;">
                    @if($msg->attachment)
                        @php $ext = pathinfo($msg->attachment, PATHINFO_EXTENSION); @endphp
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <img src="{{ asset('storage/'.$msg->attachment) }}" style="max-width:200px; border-radius:8px; display:block; margin-bottom:6px;">
                        @else
                            <a href="{{ asset('storage/'.$msg->attachment) }}" target="_blank" style="color:#4db8ff; font-size:.85rem;"><i class="bi bi-paperclip me-1"></i>Attachment</a>
                        @endif
                    @endif
                    @if($msg->message)
                    <div style="color:#f0f0f0; font-size:.92rem; line-height:1.5;">{{ $msg->message }}</div>
                    @endif
                    <div style="text-align:right; margin-top:4px; display:flex; align-items:center; justify-content:flex-end; gap:4px;">
                        <span style="color:#8888aa; font-size:.7rem;">{{ $msg->created_at->format('h:i A') }}</span>
                        <i class="bi bi-check2-all" style="color:#4db8ff; font-size:.75rem;"></i>
                    </div>
                </div>
            </div>
            @else
            {{-- User message - left --}}
            <div style="display:flex; justify-content:flex-start; gap:8px;">
                <div style="width:30px; height:30px; background:#2a2a50; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.8rem; flex-shrink:0; margin-top:4px;">👤</div>
                <div style="max-width:65%; background:#1a1a38; border-radius:12px 12px 12px 2px; padding:10px 14px;">
                    @if($msg->attachment)
                        @php $ext = pathinfo($msg->attachment, PATHINFO_EXTENSION); @endphp
                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                            <img src="{{ asset('storage/'.$msg->attachment) }}" style="max-width:200px; border-radius:8px; display:block; margin-bottom:6px;">
                        @else
                            <a href="{{ asset('storage/'.$msg->attachment) }}" target="_blank" style="color:#4db8ff; font-size:.85rem;"><i class="bi bi-paperclip me-1"></i>Attachment</a>
                        @endif
                    @endif
                    @if($msg->message)
                    <div style="color:#f0f0f0; font-size:.92rem; line-height:1.5;">{{ $msg->message }}</div>
                    @endif
                    <div style="margin-top:4px;">
                        <span style="color:#8888aa; font-size:.7rem;">{{ $msg->created_at->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Input --}}
        <div style="background:#10102a; border-top:1px solid #2a2a50; padding:12px 16px;">
            <div style="display:flex; align-items:flex-end; gap:10px;">
                <label for="attachInput" style="cursor:pointer; color:#7777aa; font-size:1.3rem; padding:8px; flex-shrink:0;">
                    <i class="bi bi-paperclip"></i>
                    <input type="file" id="attachInput" style="display:none;" accept="image/*,.pdf">
                </label>
                <div style="flex:1; background:#0a0a14; border:1px solid #2a2a50; border-radius:24px; padding:10px 16px;">
                    <textarea id="msgInput" placeholder="Type a message..." rows="1"
                        style="width:100%; background:none; border:none; outline:none; color:#f0f0f0; font-size:.92rem; resize:none; max-height:100px; font-family:inherit;"
                        onkeydown="handleKey(event)"></textarea>
                </div>
                <button onclick="sendMessage()" style="width:44px; height:44px; background:#f0a500; border:none; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0;">
                    <i class="bi bi-send-fill" style="color:#000; font-size:1rem;"></i>
                </button>
            </div>
            <div id="attachPreview" style="display:none; margin-top:8px; padding:8px 12px; background:#0a0a14; border-radius:10px; border:1px solid #2a2a50; font-size:.82rem; color:#c0c0e0; align-items:center; gap:8px;">
                <i class="bi bi-paperclip" style="color:#f0a500;"></i>
                <span id="attachName"></span>
                <button onclick="clearAttach()" style="background:none; border:none; color:#ff4d4d; cursor:pointer; margin-left:auto;"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    </div>

    @else
    {{-- No chat selected --}}
    <div style="flex:1; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:12px; color:#5a5a80;">
        <div style="font-size:4rem;">💬</div>
        <div style="font-size:1.1rem; font-weight:600; color:#7777aa;">Select a chat to start</div>
        <div style="font-size:.85rem;">Choose a user from the left panel</div>
    </div>
    @endif

</div>

@endsection
@section('scripts')
<style>
#chatBox::-webkit-scrollbar { width:4px; }
#chatBox::-webkit-scrollbar-thumb { background:#2a2a50; border-radius:4px; }
</style>
@if(isset($user))
<script>
const sendUrl   = '{{ route("admin.chat.send", $user) }}';
const pollUrl   = '{{ route("admin.chat.poll", $user) }}';
const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                  ? document.querySelector('meta[name="csrf-token"]').content 
                  : '{{ csrf_token() }}';
let lastId    = {{ isset($messages) && $messages->last() ? $messages->last()->id : 0 }};
let attachFile = null;
let sending    = false;

// Auto resize textarea
const ta = document.getElementById('msgInput');
ta.addEventListener('input', () => { ta.style.height='auto'; ta.style.height=ta.scrollHeight+'px'; });

// Attach file
document.getElementById('attachInput').addEventListener('change', function() {
    attachFile = this.files[0];
    if (attachFile) {
        document.getElementById('attachName').textContent = attachFile.name;
        document.getElementById('attachPreview').style.display = 'flex';
    }
});

function clearAttach() {
    attachFile = null;
    document.getElementById('attachInput').value = '';
    document.getElementById('attachPreview').style.display = 'none';
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
}

function sendMessage() {
    if (sending) return;
    const msg = ta.value.trim();
    if (!msg && !attachFile) return;

    sending = true;
    const fd = new FormData();
    if (msg) fd.append('message', msg);
    if (attachFile) fd.append('attachment', attachFile);
    fd.append('_token', '{{ csrf_token() }}');

    // Optimistic UI - show message immediately
    appendMessage({ sender:'admin', message: msg, time: new Date().toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit'}), attachment:null });
    ta.value = ''; ta.style.height = 'auto';
    clearAttach();

    fetch(sendUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: fd
    })
    .then(r => r.json())
    .then(() => { sending = false; loadMessages(); })
    .catch(err => { console.error('Send error:', err); sending = false; });
}

function loadMessages() {
    fetch(pollUrl, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(msgs => {
        if (!msgs.length) return;
        const newLast = msgs[msgs.length - 1].id;
        if (newLast <= lastId) return;
        lastId = newLast;
        renderMessages(msgs);
    })
    .catch(err => console.error('Poll error:', err));
}

function appendMessage(m) {
    const box = document.getElementById('chatBox');
    const wrap = buildBubble(m);
    box.appendChild(wrap);
    box.scrollTop = box.scrollHeight;
}

function buildBubble(m) {
    const wrap = document.createElement('div');
    wrap.style.cssText = `display:flex; justify-content:${m.sender==='admin'?'flex-end':'flex-start'}; ${m.sender==='user'?'gap:8px':''}; margin-bottom:2px;`;

    let inner = '';
    if (m.sender === 'user') {
        inner += `<div style="width:30px;height:30px;background:#2a2a50;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;flex-shrink:0;margin-top:4px;">👤</div>`;
    }

    const bg = m.sender === 'admin' ? '#005c4b' : '#1a1a38';
    const br = m.sender === 'admin' ? '12px 12px 2px 12px' : '12px 12px 12px 2px';
    let content = '';

    if (m.attachment) {
        const isImg = /\.(jpg|jpeg|png|gif|webp)$/i.test(m.attachment);
        content += isImg
            ? `<img src="${m.attachment}" style="max-width:200px;border-radius:8px;display:block;margin-bottom:6px;">`
            : `<a href="${m.attachment}" target="_blank" style="color:#4db8ff;font-size:.85rem;">📎 Attachment</a>`;
    }
    if (m.message) {
        content += `<div style="color:#f0f0f0;font-size:.92rem;line-height:1.5;word-break:break-word;">${m.message}</div>`;
    }

    const tick = m.sender === 'admin' ? `<i class="bi bi-check2-all" style="color:#4db8ff;font-size:.75rem;"></i>` : '';

    inner += `<div style="max-width:65%;background:${bg};border-radius:${br};padding:10px 14px;">
        ${content}
        <div style="text-align:right;margin-top:4px;display:flex;align-items:center;justify-content:flex-end;gap:4px;">
            <span style="color:#8888aa;font-size:.7rem;">${m.time}</span>${tick}
        </div>
    </div>`;

    wrap.innerHTML = inner;
    return wrap;
}

function renderMessages(msgs) {
    const box = document.getElementById('chatBox');
    const welcome = box.querySelector('[data-welcome]');
    box.innerHTML = '';
    if (welcome) box.appendChild(welcome);
    msgs.forEach(m => box.appendChild(buildBubble(m)));
    box.scrollTop = box.scrollHeight;
}

// Scroll to bottom on load
document.addEventListener('DOMContentLoaded', () => {
    const b = document.getElementById('chatBox');
    if (b) b.scrollTop = b.scrollHeight;
});

// Poll every 3 seconds
setInterval(loadMessages, 3000);
</script>
@endif
@endsection
