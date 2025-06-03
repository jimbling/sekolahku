<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with(['post', 'user', 'parent'])
            ->orderByDesc('created_at')
            ->withTrashed()
            ->paginate(20);

        $judul = 'Manajemen Komentar';

        return view('admin.blog.komentar', compact('comments', 'judul'));
    }


    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Komentar disetujui.');
    }


    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $comment->post_id,
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
            'content' => $request->content,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus sementara.');
    }

    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->restore();
        return back()->with('success', 'Komentar berhasil dipulihkan.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);
        return back()->with('success', 'Komentar telah ditolak.');
    }

    public function store(StoreCommentRequest $request)
    {
        $userId = auth()->check() ? auth()->id() : null;

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $userId,
            'guest_name' => $userId ? null : $request->guest_name,
            'guest_email' => $userId ? null : $request->guest_email,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'status' => $userId ? 'approved' : 'pending', // bisa disesuaikan
        ]);

        // Tambahkan notifikasi di sini nanti

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
