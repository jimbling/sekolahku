<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\ImageGallery;
use App\Models\Album;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ImageGallerysController extends Controller
{
    public function index()
    {
        $albums = Album::all();
        $data = [
            'judul' => "Galeri Foto",
            'foto' => $albums,
        ];

        return view('admin.media.all_photos', $data);
    }

    public function getAlbums(Request $request)
    {
        if ($request->ajax()) {
            $albums = Album::select([
                'id', 'name', 'description', 'created_at', 'updated_at'
            ]);
            return DataTables::of($albums)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn mt-1"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn mt-1"><i class="fas fa-trash-alt"></i> Hapus</a>
                    <a href="' . route('albums.upload', $row->id) . '" class="btn btn-success btn-xs mt-1"><i class="fas fa-plus "></i> Tambah Foto</a>
                    <a href="' . route('albums.foto', $row->id) . '" class="btn btn-warning btn-xs mt-1"><i class="far fa-images"></i> Atur Foto</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function albums_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photos_album' => 'required',
            'photos_keterangan' => 'required',
        ], [
            'photos_album.required' => 'Nama album harus diisi.',
            'photos_keterangan.required' => 'Keterangan album harus diisi.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        $post = new Album();
        $post->name = $request->photos_album;
        $post->description = $request->photos_keterangan;
        $post->save();
        Session::flash('success', 'Data album baru berhasil ditambahkan!');
        return response()->json([
            'success' => 'Data album baru berhasil ditambahkan!',
            'redirect' => route('photos.all')
        ]);
    }

    public function fetchAlbumsById($id)
    {
        $albums = Album::findOrFail($id);

        return response()->json($albums);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photos_album' => 'required',
            'photos_keterangan' => 'required',
        ], [
            'photos_album.required' => 'Nama album harus diisi.',
            'photos_keterangan.required' => 'Keterangan album harus diisi.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        $albums = Album::findOrFail($id);
        $albums->name = $request->photos_album;
        $albums->description = $request->photos_keterangan;
        $albums->save();
        return response()->json(['message' => 'Data Album berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        // Hapus foto-foto terkait dari penyimpanan lokal
        foreach ($album->images as $image) {
            $filePath = storage_path('app/public/' . $image->path);

            if (file_exists($filePath)) {
                unlink($filePath); // Hapus file gambar dari penyimpanan
            }
        }

        // Hapus album
        $album->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Data Album dan foto-foto terkait berhasil dihapus.'
        ]);
    }



    public function deleteSelectedAlbums(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                $albums = Album::whereIn('id', $ids)->get();

                foreach ($albums as $album) {
                    // Hapus foto-foto terkait dari penyimpanan lokal
                    foreach ($album->images as $image) {
                        $filePath = storage_path('app/public/' . $image->path);

                        if (file_exists($filePath)) {
                            unlink($filePath); // Hapus file gambar dari penyimpanan
                        }
                    }

                    // Hapus album
                    $album->delete();
                }

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data album dan foto-foto terkait berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada data album yang dipilih untuk dihapus.'
                ], 422);
            }
        }
    }


    // Manajemen Foto - Upload ke Album
    public function showUploadForm($id)
    {
        $album = Album::findOrFail($id);
        $data = [
            'judul' => "Unggah Foto"
        ];
        return view('admin.media.albums_upload', $data, compact('album'));
    }

    public function storeImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'files.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $album = Album::findOrFail($id);

        foreach ($request->file('files', []) as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('images/galeri-foto', $imageName, 'public');

            ImageGallery::create([
                'filename' => $imageName,
                'path' => $imagePath,
                'caption' => $request->input('caption', ''),
                'alt_text' => $request->input('alt_text', ''),
                'is_active' => true, // Atur status aktif sesuai kebutuhan
                'order' => $request->input('order', 0),
                'album_id' => $id,
            ]);
        }

        return response()->json(['success' => 'Gambar berhasil diupload.']);
    }

    // ATUR Foto didalam Album
    public function aturFoto($id)
    {
        // Cari album berdasarkan ID
        $album = Album::findOrFail($id);
        $data = [
            'judul' => "Atur Foto"
        ];
        // Ambil semua gambar yang terkait dengan album
        $images = $album->images()->get();

        // Tampilkan view dengan data album dan gambar
        return view('admin.media.atur_foto', $data, compact('album', 'images'));
    }

    // Menghapus foto
    public function hapusFoto($id)
    {
        // Cari gambar berdasarkan ID
        $image = ImageGallery::findOrFail($id);

        // Hapus gambar dari storage
        $filePath = storage_path('app/public/' . $image->path);

        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file
        }

        // Hapus gambar dari database
        $image->delete();

        // Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}
