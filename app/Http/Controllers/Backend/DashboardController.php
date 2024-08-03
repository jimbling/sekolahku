<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Gtk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use App\Models\Student;
use App\Models\Backup;




class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Menghitung jumlah siswa aktif
        $activeStudentCount = Student::where('student_status_id', 1)->count();
        $activeGtkCount = Gtk::where('gtk_status', 'Aktif')->count();
        $activeFileCount = File::where('file_status', 'public')->count();
        $activePostCount = Post::where('post_type', 'post')
            ->where('status', 'publish')
            ->count();

        $backups = Backup::all(); // Ambil daftar backup dari database
        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Dashboard",
            'user' => [
                'name' => $user->name,        // Nama pengguna
                'email' => $user->email,      // Email pengguna
                'isAdmin' => $user->hasRole('admin'),
                'isWriter' => $user->hasRole('writer'),
            ],
            'latestPosts' => $this->getLatestPosts(),
            'disqusComments' => $this->getDisqusComments(),
            'pesertaDidikAktif' => $activeStudentCount,
            'gtkAktif' => $activeGtkCount,
            'fileAktif' => $activeFileCount,
            'postinganAktif' => $activePostCount,
            'backups' => $backups,
        ];

        // Mengembalikan tampilan dashboard dengan data yang disiapkan
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
        // Implementasi fungsi untuk mengambil komentar Disqus
        $disqus_key = get_setting('disqus_api_key');
        $disqus_forum = get_setting('shortname_disqus');

        $response = Http::get('https://disqus.com/api/3.0/posts/list.json', [
            'api_key' => $disqus_key,
            'forum' => $disqus_forum,
            'related' => 'thread',
            'order' => 'desc',
            'limit' => 3,
        ]);

        if ($response->successful()) {
            $comments = $response->json()['response'] ?? [];

            // Konversi waktu dan tambahkan data pengirim dan post
            foreach ($comments as &$comment) {
                $createdAt = $comment['createdAt'] ?? '';
                $comment['createdAtRelative'] = Carbon::parse($createdAt, 'UTC')->setTimezone('Asia/Jakarta')->diffForHumans();
                $comment['authorName'] = $comment['author']['name'] ?? 'Unknown'; // Nama pengirim komentar
                $comment['postTitle'] = $comment['thread']['title'] ?? 'Unknown';  // Judul post yang dikomentari
                $comment['postUrl'] = $comment['thread']['link'] ?? '#'; // URL post yang dikomentari
            }

            return $comments;
        } else {
            return ['error' => 'Disqus API Error'];
        }
    }
}
