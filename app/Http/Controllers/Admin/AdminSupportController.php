<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(20);
        $stats = [
            'open'   => SupportTicket::where('status', 'open')->count(),
            'replied'=> SupportTicket::where('status', 'replied')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
        ];
        return view('admin.support.index', compact('tickets', 'stats'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate(['admin_reply' => 'required|string']);
        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status'      => 'replied',
            'replied_at'  => now(),
        ]);
        return back()->with('success', 'Reply sent successfully.');
    }

    public function close(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('success', 'Ticket closed.');
    }
}
