<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Post;

class MenuController extends Controller
{
    public function aturMenu()
    {
        $posts = Post::where('post_type', 'page')
            ->where('status', 'Publish')
            ->get();

        $data = [

            'judul' => "Pengaturan Menu",
            'posts' => $posts,
        ];
        $menus = Menu::orderBy('order')->get();

        return view('admin.tampilan.all_menu', $data, compact('menus'));
    }

    public function getMenu(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::select(['id', 'title', 'url', 'order', 'parent_id', 'is_active']);
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'menus_nama' => 'required|unique:menus,title',
            'menus_tautan' => 'required',
        ], [
            'menus_nama.required'   => 'Nama Tautan harus diisi.',
            'menus_nama.unique'     => 'Nama Tautan sudah ada, silakan masukkan yang lain.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Mengambil nilai tautan dan memastikan diawali dengan '/'
        $tautan = $request->menus_tautan;
        $tautan = '/' . ltrim($tautan, '/');

        // Menyimpan data menu dengan url yang telah diformat
        $urutan_menu = '0';
        Menu::create([
            'title' => $request->menus_nama,
            'url' => $tautan,
            'order' => $urutan_menu,
            'menu_target' => $request->input('menus_target'),
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan menu baru.',
            'redirect' => route('menus.all') // URL redirect setelah operasi berhasil
        ]);
    }

    public function fetchMenuById($id)
    {
        // Ambil data kategori berdasarkan ID
        $menus = Menu::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($menus);
    }

    public function update(Request $request, $id)
    {
        // Temukan data Menu berdasarkan ID
        $menus = Menu::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'menus_nama' => [
                'required',
                Rule::unique('menus', 'title')->ignore($menus->id)
            ],
            'menus_tautan' => 'required',
        ], [
            'menus_nama.required'   => 'Nama Tautan harus diisi.',
            'menus_nama.unique'     => 'Nama Tautan sudah ada, silakan masukkan yang lain.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        $tautan = $request->menus_tautan;
        $tautan = '/' . ltrim($tautan, '/');
        // Perbarui data Menu dengan nilai yang diterima dari permintaan
        $menus->title = $request->input('menus_nama');
        $menus->url = $tautan;
        $menus->menu_target = $request->input('menus_target');
        $menus->is_active = $request->input('menus_aktif');

        // Simpan perubahan
        $menus->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Data Menu berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $menus = Menu::findOrFail($id);

        // Hapus kategori
        $menus->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Menu berhasil dihapus.'
        ]);
    }

    public function deleteSelectedMenus(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                Menu::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Menu berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Menu yang dipilih untuk dihapus.'
                ], 422);
            }
        }
    }

    public function storeFromCheckbox(Request $request)
    {
        // Validasi ID postingan
        $request->validate([
            'posts' => 'required|array',
            'posts.*' => 'exists:posts,id',
        ]);

        // Mengambil ID postingan yang dicheck
        $selectedPosts = $request->input('posts', []);
        foreach ($selectedPosts as $postId) {
            $post = Post::find($postId);

            if ($post) {
                // Simpan data ke tabel menus
                Menu::create([
                    'title' => $post->title,
                    'url' => '/pages/' . $post->slug, // Menggunakan slug sebagai URL
                    'order' => 0, // Set urutan menu jika perlu
                    'menu_target' => $request->input('menus_target', '_self'), // Menggunakan target yang dikirimkan dari request atau default _self
                ]);
            }
        }

        return redirect()->route('menus.all')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $menu = Menu::find($item['id']);
            $menu->order = $item['order'];
            $menu->parent_id = $item['parent_id'] ?? null;
            $menu->save();
        }

        return response()->json(['status' => 'success']);
    }
}
