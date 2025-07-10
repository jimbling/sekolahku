<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Gtk;
use App\Models\File;
use App\Models\Post;
use App\Models\Backup;
use App\Models\Comment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Exceptions\InvalidFormatException;




class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nativeComments = Comment::whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['user', 'post', 'replies.user']) // memuat relasi user, post, dan semua balasan beserta user-nya
            ->orderByDesc('created_at')
            ->get();

        $lastBackup = cache()->get('last_backup_info');

        $data = [
            'judul' => "Dashboard",
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'isAdmin' => $user->hasRole('admin'),
                'isWriter' => $user->hasRole('writer'),
            ],
            'latestPosts' => $this->getLatestPosts(),
            'komentar_engine' => get_setting('komentar_engine', 'native'),
            'disqusComments' => $this->getDisqusComments(),
            'nativeComments' => $nativeComments,
            'pesertaDidikAktif' => Student::where('student_status_id', 1)->count(),
            'gtkAktif' => Gtk::where('gtk_status', 'Aktif')->count(),
            'fileAktif' => File::where('file_status', 'public')->count(),
            'postinganAktif' => Post::where('post_type', 'post')->where('status', 'publish')->count(),
            'backups' => Backup::all(),
            'cacheEnabled' => filter_var(get_setting('site_cache', false), FILTER_VALIDATE_BOOLEAN),
            'lastBackup' => $lastBackup,
        ];

        return view('admin.dashboard', $data);
    }


    private function getLatestPosts()
    {
        // Ambil 4 tulisan terbaru
        return Post::where('post_type', 'post')
            ->where('status', 'publish')
            ->latest()
            ->limit(4)
            ->get();
    }

    private function getDisqusComments()
    {
        try {
            $disqus_key = get_setting('disqus_api_key');
            $disqus_forum = get_setting('shortname_disqus');

            $response = Http::timeout(5)->get('https://disqus.com/api/3.0/posts/list.json', [
                'api_key' => $disqus_key,
                'forum' => $disqus_forum,
                'related' => 'thread',
                'order' => 'desc',
                'limit' => 3,
            ]);

            if ($response->successful()) {
                $comments = $response->json()['response'] ?? [];

                foreach ($comments as &$comment) {
                    $createdAt = $comment['createdAt'] ?? '';
                    $comment['createdAtRelative'] = Carbon::parse($createdAt, 'UTC')->setTimezone('Asia/Jakarta')->diffForHumans();
                    $comment['authorName'] = $comment['author']['name'] ?? 'Unknown';
                    $comment['postTitle'] = $comment['thread']['title'] ?? 'Unknown';
                    $comment['postUrl'] = $comment['thread']['link'] ?? '#';
                }

                return $comments;
            } else {
                return ['error' => 'Disqus API Error: ' . $response->status()];
            }
        } catch (\Exception $e) {
            return ['error' => 'Disqus API Exception: ' . $e->getMessage()];
        }
    }
}
