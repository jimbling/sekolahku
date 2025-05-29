<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

use App\Mail\NewPostNotification;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;



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
            ->where('post_type', 'post')
            ->orderBy('published_at', 'desc');

        return DataTables::of($posts)
            ->editColumn('author.name', function ($post) {
                return $post->author->name; // Pastikan relasi 'author' sudah didefinisikan di model Post
            })
            ->editColumn('published_at', function ($post) {
                return Carbon::parse($post->published_at)->translatedFormat('d F Y'); // Format tanggal
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
        // Validasi data input dengan pesan khusus
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
            'post_categories' => 'required|array|min:1',
            'post_tags' => 'nullable|array',
        ], [
            'post_title.required' => 'Judul postingan harus diisi.',
            'post_title.max' => 'Judul postingan tidak boleh lebih dari 255 karakter.',
            'post_content.required' => 'Konten postingan harus diisi.',
            'post_status.required' => 'Status postingan harus dipilih.',
            'post_status.in' => 'Status postingan harus salah satu dari Publish atau Draft.',
            'post_comment_status.required' => 'Status komentar postingan harus dipilih.',
            'post_comment_status.in' => 'Status komentar postingan harus salah satu dari open atau close.',
            'post_image.image' => 'File yang diunggah harus berupa gambar.',
            'post_image.mimes' => 'Gambar harus memiliki ekstensi: jpeg, png, jpg, atau gif.',
            'post_image.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB.',
            'post_categories.required' => 'Kategori postingan harus dipilih.',
            'post_categories.array' => 'Kategori postingan harus berupa array.',
            'post_categories.min' => 'Setidaknya satu kategori harus dipilih.',
            'post_tags.array' => 'Tags harus berupa array.',
        ]);

        $imageName = null;
        $slug = Str::slug($request->post_title);

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageResource = imagecreatefromstring(file_get_contents($image->getPathname()));
            $imageName = $slug . '-' . time() . '.webp';
            $imagePath = storage_path('app/public/uploads/posts/' . $imageName);
            imagewebp($imageResource, $imagePath, 80);
            imagedestroy($imageResource);
        }


        $slug = Str::slug($request->post_title, '-');
        $postType = 'post';
        $content = $request->post_content;
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            if (!$img->hasAttribute('alt') || $img->getAttribute('alt') === '') {
                $img->setAttribute('alt', $request->post_title);
            }
            if (!$img->hasAttribute('title') || $img->getAttribute('title') === '') {
                $img->setAttribute('title', $request->post_title);
            }
        }


        $body = $dom->getElementsByTagName('body')->item(0);
        $newContent = '';
        foreach ($body->childNodes as $child) {
            $newContent .= $dom->saveHTML($child);
        }


        $post = new Post();
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $newContent;
        $post->excerpt = substr(strip_tags($request->post_content), 0, 150) . '...';
        $post->image = $imageName;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id;
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();


        $post->category()->attach($request->post_categories);


        if ($request->has('post_tags')) {
            $tags = $request->post_tags;
            $tagIds = [];

            foreach ($tags as $tagName) {

                $tag = Tag::where('name', $tagName)->first();
                if (!$tag) {
                    $tag = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName, '-')]);
                }
                $tagIds[] = $tag->id;
            }

            $post->tags()->attach($tagIds);
        }

        // Kirim email ke setiap subscriber
        // $subscribers = Subscriber::all();
        // $postLink = route('posts.show', ['id' => $post->id, 'slug' => $post->slug]);

        // foreach ($subscribers as $subscriber) {
        //     Mail::to($subscriber->email)->send(new NewPostNotification(
        //         $post->title,
        //         $postLink,
        //         $post->excerpt,
        //         $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : 'Not published',
        //         $imageName ? asset('storage/uploads/posts/' . $imageName) : null
        //     ));
        // }

        // Set flash message
        Session::flash('success', 'Postingan berhasil ditambahkan!');

        // Redirect atau return response sesuai kebutuhan
        return redirect()->route('blog.posts');
    }



    public function edit($id)
    {
        $post = Post::with('category')->findOrFail($id);
        $categories = Category::all();
        $tags = $post->tags->pluck('name')->toArray();

        $data = [
            'judul' => "Edit Tulisan",
        ];

        return view('admin.posts.edit_posts', $data, compact('post', 'categories', 'tags'));
    }

    public function destroy($id)
    {

        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['type' => 'success', 'message' => 'Postingan berhasil dihapus.']);
    }

    public function deleteSelected(Request $request)
    {

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:posts,id',
        ]);

        $ids = $request->ids;

        try {

            Post::whereIn('id', $ids)->delete();

            return response()->json([
                'type' => 'success',
                'message' => 'Postingan terpilih berhasil dihapus.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus postingan.'
            ], 500);
        }
    }

    public function updatePublishedAt(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'published_at' => $request->published_at,
        ]);


        return response()->json(['success' => true, 'message' => 'Tanggal publikasi berhasil diperbarui.']);
    }

    public function getPostContent($id)
    {
        $post = Post::findOrFail($id);

        return response()->json(['content' => $post->content]);
    }

    public function getPublishedAt($id)
    {

        $post = Post::findOrFail($id);
        $formattedPublishedAt = Carbon::parse($post->published_at)->format('Y-m-d\TH:i');
        return response()->json([
            'published_at' => $formattedPublishedAt
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
            'post_categories' => 'required|array|min:1',
            'post_tags' => 'nullable|array',
        ]);

        $slug = Str::slug($request->post_title);
        $imageName = $post->image;

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageResource = imagecreatefromstring(file_get_contents($image->getPathname()));


            $imageName = $slug . '-' . time() . '.webp';
            $imagePath = storage_path('app/public/uploads/posts/' . $imageName);


            imagewebp($imageResource, $imagePath, 80);
            imagedestroy($imageResource);


            if ($post->image) {
                Storage::disk('public')->delete('uploads/posts/' . $post->image);
            }
        }


        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->excerpt = substr(strip_tags($request->post_content), 0, 150);
        $post->image = $imageName;
        $post->post_type = 'post';
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status === 'Publish' ? now() : null;
        $post->save();


        $post->category()->sync($request->post_categories);


        if ($request->has('post_tags')) {
            $tagIds = [];
            foreach ($request->post_tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName], ['slug' => Str::slug($tagName)]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->sync([]);
        }

        Session::flash('success', 'Postingan berhasil diperbarui!');
        return redirect()->route('blog.posts');
    }




    public function editSambutan()
    {

        $sambutan = Post::where('post_type', 'sambutan')->firstOrFail();
        $data = [
            'judul' => "Sambutan KS",
        ];

        return view('admin.blog.new_sambutan', $data, compact('sambutan'));
    }

    public function updateSambutan(Request $request)
    {

        $validatedData = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required',

        ]);


        $sambutan = Post::where('post_type', 'sambutan')->firstOrFail();


        $sambutan->update([
            'title' => $validatedData['post_title'],
            'slug' => Str::slug($validatedData['post_title']),
            'content' => $validatedData['post_content'],
            'author_id' => Auth::id(),
            'komentar_status' => 'close',
            'status' => 'Publish',
            'post_type' => 'sambutan',

        ]);


        return redirect()->route('admin.edit.sambutan')->with('success', 'Sambutan berhasil diperbarui.');
    }



    // Halaman
    public function pages()
    {

        $user = Auth::user();
        $posts = Post::where('post_type', 'page')->get();
        $data = [
            'judul' => "Halaman",
            'posts' => $posts,
        ];
        return view('admin.blog.pages.all_pages', $data);
    }

    public function getPages()
    {

        $posts = Post::with('author')
            ->select(['id', 'title', 'author_id', 'published_at', 'status', 'post_type'])
            ->where('post_type', 'page');

        return DataTables::of($posts)
            ->editColumn('author.name', function ($post) {
                return $post->author->name;
            })
            ->editColumn('published_at', function ($post) {
                return Carbon::parse($post->published_at)->translatedFormat('d F Y');
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

        $request->validate([
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_status' => 'required|in:Publish,Draft',
            'post_comment_status' => 'required|in:open,close',

        ]);



        $slug = Str::slug($request->post_title, '-');
        $postType = 'page';

        $post = new Post();
        $post->title = $request->post_title;
        $post->slug = $slug;
        $post->content = $request->post_content;
        $post->post_type = $postType;
        $post->author_id = auth()->user()->id;
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();


        Session::flash('success', 'Halaman baru berhasil ditambahkan!');


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

        ]);


        $post = Post::where('id', $id)->where('post_type', 'page')->firstOrFail();

        // Update data post
        $post->title = $validatedData['post_title'];
        $post->slug = Str::slug($validatedData['post_title']);
        $post->content = $validatedData['post_content'];
        $post->author_id = Auth::id();
        $post->komentar_status = $request->post_comment_status;
        $post->status = $request->post_status;
        $post->post_type = 'page';
        $post->published_at = $request->post_status == 'Publish' ? now() : null;
        $post->save();


        return redirect()->route('blog.pages')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function removeImage($id)
    {

        $post = Post::findOrFail($id);
        if ($post->image && Storage::exists('uploads/posts/' . $post->image)) {
            Storage::delete('uploads/posts/' . $post->image);
        }

        $post->image = null;
        $post->save();
        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus.']);
    }
}
