<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Link;

class LinkController extends Controller
{
    public function index()
    {
        $tautan = Link::all();
        $data = [
            'judul' => "Tautan",
            'tautan' => $tautan,
        ];
        return view('admin.blog.tautan', $data);
    }

    public function getTautan(Request $request)
    {
        if ($request->ajax()) {
            $tautan = Link::select(['id', 'link_title', 'link_url', 'link_target', 'link_image', 'link_type', 'created_at', 'updated_at']);
            return DataTables::of($tautan)
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

    public function simpanTautan(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'tautan_name' => 'required|string|max:255',
            'tautan_url' => 'required|string|max:255',
            'tautan_target' => 'required|string|max:255',
        ], [
            'tautan_name.required' => 'Nama tautan harus diisi',
            'tautan_url.required' => 'Url tautan harus diisi.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        $tautan_type = 'link';
        Link::create([
            'link_title'    => $request->tautan_name,
            'link_url'    => $request->tautan_url,
            'link_target'   => $request->tautan_target,
            'link_type'     => $tautan_type,
        ]);

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Tautan berhasil ditambahkan.'], 200);
    }


    public function fetchTautanById($id)
    {
        // Ambil data kategori berdasarkan ID
        $tautan = Link::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($tautan);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'link_title' => 'required|string|max:255',
            'link_url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Update data kutipan berdasarkan ID
        $tautan = Link::findOrFail($id);
        $tautan->link_title = $request->link_title;
        $tautan->link_url = $request->link_url;
        $tautan->link_target = $request->link_target;
        $tautan->link_type = 'link';
        $tautan->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Tautan berhasil diperbarui.']);
    }



    public function destroy($id)
    {
        $tautan = Link::findOrFail($id);

        // Hapus kategori
        $tautan->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Tautan berhasil dihapus.'
        ]);
    }
}
