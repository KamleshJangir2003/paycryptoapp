@extends('layouts.app')
@section('title', 'Support Chat')
@section('content')

<div style="height: calc(100vh - 140px); display:flex; flex-direction:column; background:#0d0d1a; border:1px solid #2a2a50; border-radius:14px; overflow:hidden;">

    {{-- Header --}}
    <div style="background:#13132b; padding:14px 20px; border-bottom:1px solid #2a2a50; display:flex; align-items:center; gap:12px;">
        <div style="width:42px;height:42px;background:#f0a500;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">🛡️</div>
        <div>
            <div style="color:#f0f0f0;font-weight:700;font-size:.95rem;">FastPayz Support</div>
            <div style="color:#4cdf80;font-size:.78rem;">● Online</div>
        </div>
    </div>

    {{-- Messages --}}
    <div id="chatBox" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:8px;">
        <div data-welcome style="text-align:center;margin:10px 0;">
            <span style="background:#1a1a38;color:#7777aa;font-size:.78rem;padding:6px 14px;border-radius:20px;">
                Chat started • {{ now()->format('d M Y') }}
            </span>
        </div>

        @foreach($messages as $msg)
        @if($msg->sender === 'user')
        <div style="display:flex;justify-content:flex-end;">
            <div style="max-width:70%;background:#005c4b;border-radius:12px 12px 2px 12px;padding:10px 14px;">
                @if($msg->attachment)
                    @if(in_array(pathinfo($msg->attachment,PATHINFO_EXTENSION),['jpg','jpeg','png','gif','webp']))
                        <img src="{{ asset('storage/'.$msg->attachment) }}" style="max-width:200px;border-radius:8px;display:block;margin-bottom:6px;">
                    @else
                        <a href="{{ asset('storage/'.$msg->attachment) }}" target="_blank" style="color:#4db8ff;font-size:.85rem;">📎 Attachment</a>
                    @endif
                @endif
                @if($msg->message)<div style="color:#f0f0f0;font-size:.92rem;line-height:1.5;">{{ $msg->message }}</div>@endif
                <div style="text-align:right;margin-top:4px;display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                    <span style="color:#8888aa;font-size:.7rem;">{{ $msg->created_at->format('h:i A') }}</span>
                    <i class="bi bi-check2-all" style="color:#4db8ff;font-size:.75rem;"></i>
                </div>
            </div>
        </div>
        @else
        <div style="display:flex;justify-content:flex-start;gap:8px;">
            <div style="width:30px;height:30px;background:#f0a500;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;flex-shrink:0;margin-top:4px;">🛡️</div>
            <div style="max-width:70%;background:#1a1a38;border-radius:12px 12px 12px 2px;padding:10px 14px;">
                <div style="color:#f0a500;font-size:.72rem;font-weight:700;margin-bottom:4px;">FastPayz Support</div>
                @if($msg->attachment)
                    @if(in_array(pathinfo($msg->attachment,PATHINFO_EXTENSION),['jpg','jpeg','png','gif','webp']))
                        <img src="{{ asset('storage/'.$msg->attachment) }}" style="max-width:200px;border-radius:8px;display:block;margin-bottom:6px;">
                    @else
                        <a href="{{ asset('storage/'.$msg->attachment) }}" target="_blank" style="color:#4db8ff;font-size:.85rem;">📎 Attachment</a>
                    @endif
                @endif
                @if($msg->message)<div style="color:#f0f0f0;font-size:.92rem;line-height:1.5;">{{ $msg->message }}</div>@endif
                <div style="margin-top:4px;">
                    <span style="color:#8888aa;font-size:.7rem;">{{ $msg->created_at->format('h:i A') }}</span>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Input --}}
    <div style="background:#13132b;border-top:1px solid #2a2a50;padding:12px 16px;">
        <div style="display:flex;align-items:flex-end;gap:10px;">
            <label for="attachInput" style="cursor:pointer;color:#7777aa;font-size:1.3rem;padding:8px;flex-shrink:0;">
                <i class="bi bi-paperclip"></i>
                <input type="file" id="attachInput" style="display:none;" accept="image/*,.pdf">
            </label>
            <div style="flex:1;background:#0d0d1a;border:1px solid #2a2a50;border-radius:24px;padding:10px 16px;">
                <textarea id="msgInput" placeholder="Type a message..." rows="1"
                    style="width:100%;background:none;border:none;outline:none;color:#f0f0f0;font-size:.92rem;resize:none;max-height:100px;font-family:inherit;"
                    onkeydown="handleKey(event)"></textarea>
            </div>
            <button onclick="sendMessage()" style="width:44px;height:44px;background:#f0a500;border:none;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;">
                <i class="bi bi-send-fill" style="color:#000;font-size:1rem;"></i>
            </button>
        </div>
        <div id="attachPreview" style="display:none;margin-top:8px;padding:8px 12px;background:#0d0d1a;border-radius:10px;border:1px solid #2a2a50;font-size:.82rem;color:#c0c0e0;align-items:center;gap:8px;">
            <i class="bi bi-paperclip" style="color:#f0a500;"></i>
            <span id="attachName"></span>
            <button onclick="clearAttach()" style="background:none;border:none;color:#ff4d4d;cursor:pointer;margin-left:auto;"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<style>
#chatBox::-webkit-scrollbar{width:4px}
#chatBox::-webkit-scrollbar-thumb{background:#2a2a50;border-radius:4px}
</style>
<script>
const SEND_URL = '{{ route("chat.send") }}';
const POLL_URL = '{{ route("chat.poll") }}';
const CSRF     = '{{ csrf_token() }}';
let lastId     = {{ $messages->last()?->id ?? 0 }};
let attachFile = null;
let sending    = false;

const ta = document.getElementById('msgInput');
ta.addEventListener('input', () => { ta.style.height='auto'; ta.style.height=ta.scrollHeight+'px'; });

document.getElementById('attachInput').addEventListener('change', function(){
    attachFile = this.files[0];
    if(attachFile){
        document.getElementById('attachName').textContent = attachFile.name;
        document.getElementById('attachPreview').style.display = 'flex';
    }
});

function clearAttach(){
    attachFile = null;
    document.getElementById('attachInput').value = '';
    document.getElementById('attachPreview').style.display = 'none';
}

function handleKey(e){
    if(e.key==='Enter' && !e.shiftKey){ e.preventDefault(); sendMessage(); }
}

function sendMessage(){
    if(sending) return;
    const msg = ta.value.trim();
    if(!msg && !attachFile) return;

    sending = true;
    const fd = new FormData();
    if(msg) fd.append('message', msg);
    if(attachFile) fd.append('attachment', attachFile);
    fd.append('_token', CSRF);

    appendBubble({ sender:'user', message:msg, time:nowTime(), attachment:null });
    ta.value=''; ta.style.height='auto';
    clearAttach();

    fetch(SEND_URL, {
        method:'POST',
        headers:{'X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body:fd
    })
    .then(r=>r.json())
    .then(()=>{ sending=false; poll(); })
    .catch(e=>{ console.error(e); sending=false; });
}

function poll(){
    fetch(POLL_URL, {headers:{'Accept':'application/json','X-CSRF-TOKEN':CSRF}})
    .then(r=>r.json())
    .then(msgs=>{
        if(!msgs.length) return;
        const newLast = msgs[msgs.length-1].id;
        if(newLast <= lastId) return;
        lastId = newLast;
        renderAll(msgs);
    })
    .catch(e=>console.error(e));
}

function nowTime(){
    return new Date().toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit'});
}

function makeBubble(m){
    const wrap = document.createElement('div');
    const isUser = m.sender==='user';
    wrap.style.cssText = `display:flex;justify-content:${isUser?'flex-end':'flex-start'};${!isUser?'gap:8px':''};margin-bottom:2px;`;

    let inner = '';
    if(!isUser) inner += `<div style="width:30px;height:30px;background:#f0a500;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;flex-shrink:0;margin-top:4px;">🛡️</div>`;

    const bg = isUser ? '#005c4b' : '#1a1a38';
    const br = isUser ? '12px 12px 2px 12px' : '12px 12px 12px 2px';
    const label = !isUser ? `<div style="color:#f0a500;font-size:.72rem;font-weight:700;margin-bottom:4px;">FastPayz Support</div>` : '';
    const tick  = isUser  ? `<i class="bi bi-check2-all" style="color:#4db8ff;font-size:.75rem;"></i>` : '';

    let content = '';
    if(m.attachment){
        const isImg = /\.(jpg|jpeg|png|gif|webp)$/i.test(m.attachment);
        content += isImg
            ? `<img src="${m.attachment}" style="max-width:200px;border-radius:8px;display:block;margin-bottom:6px;">`
            : `<a href="${m.attachment}" target="_blank" style="color:#4db8ff;font-size:.85rem;">📎 Attachment</a>`;
    }
    if(m.message) content += `<div style="color:#f0f0f0;font-size:.92rem;line-height:1.5;word-break:break-word;">${m.message}</div>`;

    inner += `<div style="max-width:70%;background:${bg};border-radius:${br};padding:10px 14px;">
        ${label}${content}
        <div style="text-align:right;margin-top:4px;display:flex;align-items:center;justify-content:flex-end;gap:4px;">
            <span style="color:#8888aa;font-size:.7rem;">${m.time}</span>${tick}
        </div>
    </div>`;

    wrap.innerHTML = inner;
    return wrap;
}

function appendBubble(m){
    const box = document.getElementById('chatBox');
    box.appendChild(makeBubble(m));
    box.scrollTop = box.scrollHeight;
}

function renderAll(msgs){
    const box = document.getElementById('chatBox');
    const welcome = box.querySelector('[data-welcome]');
    box.innerHTML = '';
    if(welcome) box.appendChild(welcome);
    msgs.forEach(m => box.appendChild(makeBubble(m)));
    box.scrollTop = box.scrollHeight;
}

document.addEventListener('DOMContentLoaded', ()=>{
    const b = document.getElementById('chatBox');
    if(b) b.scrollTop = b.scrollHeight;
});

setInterval(poll, 3000);
</script>
@endsection
