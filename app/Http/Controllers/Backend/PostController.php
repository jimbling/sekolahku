<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Backend\Blog\PostService;
use App\Services\Backend\Blog\HalamanService;
use App\Services\Backend\Blog\SambutanService;
use App\Http\Requests\Backend\Blog\Post\PostRequest;
use App\Http\Requests\Backend\Blog\Post\HalamanRequest;
use App\Http\Requests\Backend\Blog\Post\SambutanRequest;

class PostController extends Controller
{


    protected $postService;
    protected $sambutanService;
    protected $halamanService;

    public function __construct(PostService $postService, SambutanService $sambutanService, HalamanService $halamanService)
    {
        $this->postService = $postService;
        $this->sambutanService = $sambutanService;
        $this->halamanService = $halamanService;
    }

    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('Administrator');
        $isWriter = $user->hasRole('Penulis Berita');
        $posts = $this->postService->getAllPosts();

        $data = [
            'judul' => "All Posts",
            'isAdmin' => $isAdmin,
            'isWriter' => $isWriter,
            'posts' => $posts,
        ];

        return view('admin.posts.all_posts', $data);
    }

    public function getPosts()
    {
        $posts = $this->postService->getPostsForDatatables();
        return datatables()->of($posts)
            ->editColumn('author.name', function ($post) {
                return $post->author->name;
            })
            ->editColumn('published_at', function ($post) {
                return $post->published_at?->translatedFormat('d F Y');
            })
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();
        $data = [
            'judul' => "Tambah Tulisan",
            'categories' => $categories,
        ];
        return view('admin.posts.new_posts', $data);
    }

    public function store(PostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request->all());

            Session::flash('success', 'Postingan berhasil ditambahkan!');
            return redirect()->route('blog.posts');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal membuat postingan: ' . $e->getMessage());
            return back()->withInput();
        }
    }



    public function edit($id)
    {
        $post = $this->postService->findPostWithRelations($id);
        $categories = $this->postService->getAllCategories();
        $tags = $this->postService->getPostTags($post);

        $data = [
            'judul' => "Edit Tulisan",
        ];

        return view('admin.posts.edit_posts', $data, compact('post', 'categories', 'tags'));
    }

    public function destroy($id)
    {
        try {
            $this->postService->deletePost($id);
            return response()->json([
                'type' => 'success',
                'message' => 'Postingan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Gagal menghapus postingan.'
            ], 500);
        }
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:posts,id',
        ]);

        try {
            $this->postService->deleteMultiplePosts($request->ids);
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
        try {
            $this->postService->updatePublishedAt($id, $request->published_at);
            return response()->json([
                'success' => true,
                'message' => 'Tanggal publikasi berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tanggal publikasi.'
            ], 500);
        }
    }

    public function getPostContent($id)
    {
        try {
            $content = $this->postService->getPostContent($id);
            return response()->json(['content' => $content]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil konten postingan'
            ], 500);
        }
    }

    public function getPublishedAt($id)
    {
        try {
            $publishedAt = $this->postService->getFormattedPublishedAt($id);
            return response()->json([
                'published_at' => $publishedAt
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil tanggal publikasi'
            ], 500);
        }
    }

    public function update(PostRequest $request, $id)
    {
        try {
            // Get validated data from request
            $validatedData = $request->validated();

            // Add file to data if present
            if ($request->hasFile('post_image')) {
                $validatedData['post_image'] = $request->file('post_image');
            }

            // Update the post
            $this->postService->updatePost($id, $validatedData);

            Session::flash('success', 'Postingan berhasil diperbarui!');
            return redirect()->route('blog.posts');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal memperbarui postingan: ' . $e->getMessage());
            return back()->withInput();
        }
    }




    public function editSambutan()
    {
        $sambutan = $this->sambutanService->getSambutan();

        return view('admin.blog.new_sambutan', [
            'judul' => 'Sambutan KS',
            'sambutan' => $sambutan
        ]);
    }

    public function updateSambutan(SambutanRequest $request)
    {
        $this->sambutanService->updateSambutan($request->validated());

        return redirect()->route('admin.edit.sambutan')->with('success', 'Sambutan berhasil diperbarui.');
    }



    // Halaman
    public function pages()
    {
        $posts = $this->halamanService->getAllPages();
        return view('admin.blog.pages.all_pages', [
            'judul' => 'Halaman',
            'posts' => $posts
        ]);
    }

    public function getPages()
    {
        $posts = $this->halamanService->getPagesDataTable();

        return DataTables::of($posts)
            ->editColumn('author.name', fn($post) => $post->author->name)
            ->editColumn('published_at', fn($post) => \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y'))
            ->make(true);
    }

    public function create_pages()
    {
        return view('admin.blog.pages.new_pages', ['judul' => 'Tambah Halaman']);
    }

    public function pages_store(HalamanRequest $request)
    {
        $this->halamanService->store($request->validated());
        return redirect()->route('blog.pages')->with('success', 'Halaman baru berhasil ditambahkan!');
    }

    public function editPages($id)
    {
        $post = Post::where('post_type', 'page')->findOrFail($id);
        return view('admin.blog.pages.edit_pages', [
            'judul' => 'Edit Halaman',
            'post' => $post
        ]);
    }

    public function updatePages(HalamanRequest $request, $id)
    {
        $post = Post::where('id', $id)->where('post_type', 'page')->firstOrFail();
        $this->halamanService->update($post, $request->validated());

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
