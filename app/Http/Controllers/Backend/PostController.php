<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    public function index()
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Memeriksa peran pengguna
        $isAdmin = $user->hasRole('Administrator');
        $isWriter = $user->hasRole('Penulis Berita');

        // Mengambil semua posting
        $posts = Post::all();

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "All Posts",
            'isAdmin' => $isAdmin,
            'isWriter' => $isWriter,
            'posts' => $posts,
        ];

        // Mengembalikan tampilan dengan data yang disiapkan
        return view('admin.posts.all_posts', $data);
    }

    public function getPosts()
    {
        // Ambil data post dengan informasi penulis, hanya untuk post_type "post"
        $posts = Post::with('author')
            ->select(['id', 'title', 'author_id', 'published_at', 'status', 'post_type'])
            ->where('post_type', 'post'); // Tambahkan filter untuk post_type

        return DataTables::of($posts)
            ->editColumn('author.name', function ($post) {
                return $post->author->name; // Pastikan relasi 'author' sudah didefinisikan di model Post
            })
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori dari database
        $data = [
            'judul' => "Tambah Tulisan",
            'categories' => $categories, // Kirim data kategori ke view
        ];
        return view('admin.posts.new_posts', $data);
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:5048', // adjust as needed
            'post_categories' => 'required|array|min:1', // assuming at least one category is required
            'post_tags' => 'nullable|array', // tags bisa null atau array
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('post_image')) {
            $imagePath = $request->file('post_image')->store('images/posts', 'public');
            $imageName = basename($imagePath);
        } else {
            $imageName = null;
        }

        // Buat slug dari judul post
        $slug = Str::slug($request->post_title, '-');
        $postType = 'post';
        // Simpan data post ke database
        $post = new Post();
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->excerpt = substr(strip_tags($request->post_content), 0, 150);
        $post->image = $imageName;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id; // Sesuaikan dengan logika author
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();

        // Attach kategori yang dipilih
        $post->category()->attach($request->post_categories);

        // Mengelola tags
        if ($request->has('post_tags')) {
            $tags = $request->post_tags;
            $tagIds = [];

            foreach ($tags as $tagName) {
                // Cek apakah tag sudah ada
                $tag = Tag::where('name', $tagName)->first();

                if (!$tag) {
                    // Jika belum ada, buat tag baru
                    $tag = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName, '-')]);
                }

                $tagIds[] = $tag->id;
            }

            // Attach tags ke post
            $post->tags()->attach($tagIds);
        }

        // Set flash message
        Session::flash('success', 'Postingan berhasil ditambahkan!');

        // Redirect atau return response sesuai kebutuhan
        return redirect()->route('blog.posts');
    }

    public function edit($id)
    {
        $post = Post::with('category')->findOrFail($id);
        $categories = Category::all(); // Ganti dengan logika untuk mendapatkan kategori
        $tags = $post->tags->pluck('name')->toArray(); // Ambil tag yang sudah terhubung dengan post

        // Menambahkan dd() untuk memeriksa nilai variabel


        $data = [
            'judul' => "Edit Tulisan",
        ];

        return view('admin.posts.edit_posts', $data, compact('post', 'categories', 'tags'));
    }

    public function destroy($id)
    {
        // Temukan post berdasarkan id
        $post = Post::findOrFail($id);

        // Lakukan penghapusan
        $post->delete();

        // Kembalikan respons JSON untuk digunakan dengan AJAX
        return response()->json(['type' => 'success', 'message' => 'Postingan berhasil dihapus.']);
    }

    public function deleteSelected(Request $request)
    {
        // Validasi request
        $request->validate([
            'ids' => 'required|array', // Pastikan ids adalah array
            'ids.*' => 'exists:posts,id', // Pastikan setiap id dalam array ada di tabel posts
        ]);

        // Ambil ids yang dikirim dari request
        $ids = $request->ids;

        try {
            // Hapus postingan berdasarkan ids yang dipilih
            Post::whereIn('id', $ids)->delete();

            // Berikan respons sukses
            return response()->json([
                'type' => 'success',
                'message' => 'Postingan terpilih berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json([
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus postingan.'
            ], 500); // 500 adalah kode status server error
        }
    }

    public function updatePublishedAt(Request $request, $id)
    {
        // Validasi request jika diperlukan

        // Temukan postingan berdasarkan ID
        $post = Post::findOrFail($id);

        // Update kolom published_at
        $post->update([
            'published_at' => $request->published_at, // Sesuaikan dengan nama field form
        ]);

        // Berikan respons JSON atau redirect sesuai kebutuhan
        return response()->json(['success' => true, 'message' => 'Tanggal publikasi berhasil diperbarui.']);
    }

    public function getPostContent($id)
    {
        $post = Post::findOrFail($id);

        return response()->json(['content' => $post->content]);
    }

    public function getPublishedAt($id)
    {
        // Temukan post berdasarkan id
        $post = Post::findOrFail($id);

        // Format published_at ke format ISO 8601 (YYYY-MM-DDTHH:MM)
        $formattedPublishedAt = Carbon::parse($post->published_at)->format('Y-m-d\TH:i');

        // Mengembalikan response JSON dengan tanggal published_at
        return response()->json([
            'published_at' => $formattedPublishedAt
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Validasi data input
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:5048', // adjust as needed
            'post_categories' => 'required|array|min:1', // assuming at least one category is required
            'post_tags' => 'nullable|array', // tags bisa null atau array
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('post_image')) {
            $imagePath = $request->file('post_image')->store('uploads/posts', 'public');
            $imageName = basename($imagePath);

            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete('images/posts/' . $post->image);
            }
        } else {
            $imageName = $post->image;
        }

        // Buat slug dari judul post
        $slug = Str::slug($request->post_title, '-');
        $postType = 'post';
        // Simpan data post ke database
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->excerpt = substr(strip_tags($request->post_content), 0, 150);
        $post->image = $imageName;
        $post->post_type = $postType;
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();

        // Sync kategori yang dipilih
        $post->category()->sync($request->post_categories);

        // Mengelola tags
        if ($request->has('post_tags')) {
            $tags = $request->post_tags;
            $tagIds = [];

            foreach ($tags as $tagName) {
                // Cek apakah tag sudah ada
                $tag = Tag::where('name', $tagName)->first();

                if (!$tag) {
                    // Jika belum ada, buat tag baru
                    $tag = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName, '-')]);
                }

                $tagIds[] = $tag->id;
            }

            // Sync tags ke post
            $post->tags()->sync($tagIds);
        } else {
            // Jika tidak ada tag dipilih, kosongkan tags yang terkait dengan post
            $post->tags()->sync([]);
        }

        // Set flash message
        Session::flash('success', 'Postingan berhasil diperbarui!');

        // Redirect atau return response sesuai kebutuhan
        return redirect()->route('blog.posts');
    }

    // Sambutan Kepala Sekolah
    public function editSambutan()
    {
        // Cari post dengan post_type 'sambutan'
        $sambutan = Post::where('post_type', 'sambutan')->firstOrFail();
        $data = [
            'judul' => "Sambutan KS",
        ];
        // Tampilkan view dengan data sambutan
        return view('admin.blog.new_sambutan', $data, compact('sambutan'));
    }

    public function updateSambutan(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari post dengan post_type 'sambutan'
        $sambutan = Post::where('post_type', 'sambutan')->firstOrFail();

        // Update data sambutan, termasuk author_id
        $sambutan->update([
            'title' => $validatedData['post_title'],
            'slug' => Str::slug($validatedData['post_title']),
            'content' => $validatedData['post_content'],
            'author_id' => Auth::id(), // Ambil ID pengguna yang sedang login
            'komentar_status' => 'close',
            'status' => 'Publish',
            'post_type' => 'sambutan',
            // tambahkan pembaruan lainnya sesuai kebutuhan
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.edit.sambutan')->with('success', 'Sambutan berhasil diperbarui.');
    }



    // Halaman
    public function pages()
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Mengambil semua posting dengan post_type 'page'
        $posts = Post::where('post_type', 'page')->get();

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Halaman",
            'posts' => $posts,
        ];

        // Mengembalikan tampilan dengan data yang disiapkan
        return view('admin.blog.pages.all_pages', $data);
    }

    public function getPages()
    {
        // Ambil data post dengan informasi penulis, hanya untuk post_type "post"
        $posts = Post::with('author')
            ->select(['id', 'title', 'author_id', 'published_at', 'status', 'post_type'])
            ->where('post_type', 'page'); // Tambahkan filter untuk post_type

        return DataTables::of($posts)
            ->editColumn('author.name', function ($post) {
                return $post->author->name; // Pastikan relasi 'author' sudah didefinisikan di model Post
            })
            ->make(true);
    }

    public function create_pages()
    {

        $data = [
            'judul' => "Tambah Halaman",

        ];
        return view('admin.blog.pages.new_pages', $data);
    }

    public function pages_store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',

        ]);


        // Buat slug dari judul post
        $slug = Str::slug($request->post_title, '-');
        $postType = 'page';
        // Simpan data post ke database
        $post = new Post();
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id; // Sesuaikan dengan logika author
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();

        // Set flash message
        Session::flash('success', 'Halaman baru berhasil ditambahkan!');

        // Redirect atau return response sesuai kebutuhan
        return redirect()->route('blog.pages');
    }

    public function editPages($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'judul' => "Edit Halaman",
        ];

        return view('admin.blog.pages.edit_pages', $data, compact('post'));
    }

    public function updatePages(Request $request, $id)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Cari post berdasarkan ID dan post_type 'page'
        $post = Post::where('id', $id)->where('post_type', 'page')->firstOrFail();

        // Update data post
        $post->title = $validatedData['post_title'];
        $post->slug = Str::slug($validatedData['post_title']);
        $post->content = $validatedData['post_content'];
        $post->author_id = Auth::id(); // Ambil ID pengguna yang sedang login
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->post_type = 'page';
        $post->published_at = $request->post_status == 'Publish' ? now() : null;

        // Simpan perubahan
        $post->save();

        // Redirect dengan pesan sukses
        return redirect()->route('blog.pages')->with('success', 'Halaman berhasil diperbarui.');
    }
}
