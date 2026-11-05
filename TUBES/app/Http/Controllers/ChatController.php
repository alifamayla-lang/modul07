<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Tampilkan halaman chat lalu lintas.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'asc')->take(50)->get();
        $user = Auth::user();

        return view('chat', compact('messages', 'user'));
    }

    /**
     * Kirim pesan baru ke chat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
        ]);

        Message::create([
            'sender' => Auth::user()->name,
            'message' => $request->message,
        ]);

        return redirect()->route('chat')->with('success', 'Pesan terkirim!');
    }
}
