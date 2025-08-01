<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Yajra\DataTables\DataTables;
use App\Mail\ReplyMessage;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.blog.pesan.all_pesan', ['judul' => 'Pesan Masuk']);
    }

    public function show($id)
    {
        $data = [
            'judul' => "Detail Pesan Masuk",
        ];

        // Temukan pesan dengan balasannya
        $message = Message::with('replies')->findOrFail($id);

        // Update status pesan menjadi dibaca
        $message->update(['is_read' => true]);

        return view('admin.blog.pesan.pesan_detail', $data, compact('message'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
    }


    public function getData()
    {
        $messages = Message::select(['id', 'name', 'email', 'subject', 'is_read', 'message', 'created_at'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($messages)
            ->addColumn('action', function ($message) {
                return '<a href="' . route('admin.messages.show', $message->id) . '" class="btn btn-xs btn-primary">Lihat Pesan</a>';
            })
            ->make(true);
    }

    public function storeReply(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'reply' => 'required|string', // reply harus diisi dan bertipe string
        ], [
            'reply.required' => 'Kolom balasan harus diisi.',
        ]);

        $message = Message::findOrFail($id);

        $reply = $message->replies()->create([
            'reply' => $request->input('reply'),
            'reply_by' => auth()->user()->name, // atau sesuai dengan logikamu
        ]);

        // Kirim email ke pengirim pesan
        Mail::to($message->email)->send(new ReplyMessage($reply, $message));

        return redirect()->back()->with('success', 'Email balasan berhasil dikirim.');
    }
}
