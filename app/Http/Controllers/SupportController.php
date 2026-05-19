<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->supportTickets()->latest()->paginate(10);
        return view('support.index', compact('tickets'));
    }

    public function create() { return view('support.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:200',
            'message'    => 'required|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $path = $request->file('attachment')?->store('support', 'public');

        SupportTicket::create([
            'user_id'    => Auth::id(),
            'subject'    => $request->subject,
            'message'    => $request->message,
            'attachment' => $path,
        ]);

        return redirect()->route('support.index')->with('success', 'Ticket submitted successfully.');
    }
}
