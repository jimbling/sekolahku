<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index()
    {
        $posts = Post::where('post_type', 'video')->get();

        $data = [
            'judul' => "Galeri Video",
            'posts' => $posts,
        ];

        return view('admin.media.all_video', $data);
    }

    public function getVideoPosts()
    {
        $posts = Post::select('id', 'title', 'content', 'post_type', 'created_at', 'updated_at')
            ->where('post_type', 'video')
            ->get();

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                return '
                <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
            ';
            })
            ->editColumn('content', function ($row) {
                // Cek apakah 'content' adalah URL YouTube
                if (strpos($row->content, 'https://www.youtube.com/watch?v=') === 0) {
                    // Ambil ID video dari URL
                    $videoId = parse_url($row->content, PHP_URL_QUERY);
                    parse_str($videoId, $query);
                    $videoId = $query['v'] ?? '';

                    // Buat link untuk video YouTube
                    return '<a href="' . $row->content . '" target="_blank" class="text-blue-500 hover:underline">Tonton Video</a>';
                }

                // Jika bukan URL YouTube, tampilkan konten apa adanya
                return $row->content;
            })
            ->rawColumns(['content', 'action'])
            ->make(true);
    }


    public function videos_store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
        ]);

        // Buat slug dari judul post
        $slug = Str::slug($request->post_title, '-');
        $postType = 'video';
        $postStatus = 'Publish';
        $postKomentar = 'close';

        // Simpan data post ke database
        $post = new Post();
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id; // Sesuaikan dengan logika author
        $post->komentar_status = $postKomentar;
        $post->status = $postStatus;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();

        // Set flash message
        Session::flash('success', 'Video baru berhasil ditambahkan!');

        // Kembalikan respons JSON
        return response()->json([
            'success' => 'Video baru berhasil ditambahkan!',
            'redirect' => route('videos.all') // URL redirect setelah operasi berhasil
        ]);
    }

    public function fetchVideosById($id)
    {

        $videos = Post::findOrFail($id);

        return response()->json($videos);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'post_title' => 'required|string|max:255',
            'post_content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Buat slug dari judul post
        $slug = Str::slug($request->post_title, '-');
        $postType = 'video';
        $postStatus = 'Publish';
        $postKomentar = 'close';

        // Simpan data post ke database
        $post = Post::findOrFail($id);
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id; // Sesuaikan dengan logika author
        $post->komentar_status = $postKomentar;
        $post->status = $postStatus;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Data Video berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $videos = Post::findOrFail($id);

        // Hapus kategori
        $videos->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Data Video berhasil dihapus.'
        ]);
    }

    public function deleteSelectedVideos(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            // Lakukan validasi atau operasi penghapusan di sini
            // Contoh validasi: pastikan id yang dikirim adalah array dan bukan kosong

            if (!empty($ids)) {
                Post::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Video berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Video yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }
}
