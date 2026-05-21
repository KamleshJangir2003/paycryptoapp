<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at')->get();

        // Mark admin messages as read
        ChatMessage::where('user_id', Auth::id())
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('support.chat', compact('messages'));
    }

    public function send(Request $request)
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
            'user_id'    => Auth::id(),
            'sender'     => 'user',
            'message'    => $request->message ?? '',
            'attachment' => $path,
            'is_read'    => false,
        ]);

        return response()->json(['status' => 'sent']);
    }

    public function poll()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at')->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender,
                'message'    => $m->message,
                'attachment' => $m->attachment ? asset('storage/' . $m->attachment) : null,
                'time'       => $m->created_at->format('h:i A'),
                'is_read'    => $m->is_read,
            ]);

        ChatMessage::where('user_id', Auth::id())
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
