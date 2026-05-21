<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ChatMessage, User};
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
    {
        // All users who have sent at least one message
        $users = User::whereHas('chatMessages')
            ->where('id', '!=', auth()->id())
            ->withCount(['chatMessages as unread' => fn($q) =>
                $q->where('sender', 'user')->where('is_read', false)
            ])
            ->with(['chatMessages' => fn($q) => $q->latest()->limit(1)])
            ->get()
            ->sortByDesc(fn($u) => optional($u->chatMessages->first())->created_at);

        $totalUnread = ChatMessage::where('sender', 'user')->where('is_read', false)->count();

        return view('admin.support.chat', compact('users', 'totalUnread'));
    }

    public function show(User $user)
    {
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at')->get();

        // Mark user messages as read
        ChatMessage::where('user_id', $user->id)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $users = User::whereHas('chatMessages')
            ->where('id', '!=', auth()->id())
            ->withCount(['chatMessages as unread' => fn($q) =>
                $q->where('sender', 'user')->where('is_read', false)
            ])
            ->with(['chatMessages' => fn($q) => $q->latest()->limit(1)])
            ->get()
            ->sortByDesc(fn($u) => optional($u->chatMessages->first())->created_at);

        $totalUnread = ChatMessage::where('sender', 'user')->where('is_read', false)->count();

        return view('admin.support.chat', compact('users', 'user', 'messages', 'totalUnread'));
    }

    public function send(Request $request, User $user)
    {
        $request->validate([
            'message'    => 'required_without:attachment|nullable|string|max:1000',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('chat', 'public');
        }

        ChatMessage::create([
            'user_id'    => $user->id,
            'sender'     => 'admin',
            'message'    => $request->message ?? '',
            'attachment' => $path,
            'is_read'    => false,
        ]);

        return response()->json(['status' => 'sent']);
    }

    public function poll(User $user)
    {
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at')->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender,
                'message'    => $m->message,
                'attachment' => $m->attachment ? asset('storage/' . $m->attachment) : null,
                'time'       => $m->created_at->format('h:i A'),
                'is_read'    => $m->is_read,
            ]);

        ChatMessage::where('user_id', $user->id)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
