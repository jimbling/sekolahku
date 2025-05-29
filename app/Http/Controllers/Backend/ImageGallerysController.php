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
                'id',
                'name',
                'description',
                'cover_photo',
                'created_at',
                'updated_at'
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
        // Validasi data
        $validator = Validator::make($request->all(), [
            'photos_album' => 'required',
            'photos_keterangan' => 'required',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file foto sampul
        ], [
            'photos_album.required' => 'Nama album harus diisi.',
            'photos_keterangan.required' => 'Keterangan album harus diisi.',
            'cover_photo.image' => 'File sampul harus berupa gambar.',
            'cover_photo.mimes' => 'Format gambar yang diterima adalah jpeg, png, atau jpg.',
            'cover_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $post = new Album();
        $post->name = $request->photos_album;
        $post->description = $request->photos_keterangan;

        // Jika ada foto sampul yang diunggah
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');

            // Tentukan path untuk menyimpan gambar asli
            $imagePath = $file->store('images/album_covers', 'public');

            // Buat gambar dari file yang diupload menggunakan GD
            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

            // Tentukan nama dan path untuk file WebP
            $webpFilename = time() . '.webp';
            $webpPath = 'images/album_covers/' . $webpFilename;
            $webpFullPath = storage_path('app/public/' . $webpPath);

            // Konversi gambar ke WebP dan simpan
            imagewebp($imageResource, $webpFullPath);
            imagedestroy($imageResource);

            // Hapus gambar asli (JPEG/PNG) jika diperlukan
            Storage::disk('public')->delete($imagePath);

            // Simpan path lengkap file WebP di kolom cover_photo
            $post->cover_photo = $webpPath;
        }

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
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file foto sampul
        ], [
            'photos_album.required' => 'Nama album harus diisi.',
            'photos_keterangan.required' => 'Keterangan album harus diisi.',
            'cover_photo.image' => 'File sampul harus berupa gambar.',
            'cover_photo.mimes' => 'Format gambar yang diterima adalah jpeg, png, atau jpg.',
            'cover_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $albums = Album::findOrFail($id);
        $albums->name = $request->photos_album;
        $albums->description = $request->photos_keterangan;

        // Menyimpan file foto jika ada
        if ($request->hasFile('cover_photo')) {
            // Hapus foto lama jika ada
            if ($albums->cover_photo && Storage::disk('public')->exists($albums->cover_photo)) {
                Storage::disk('public')->delete($albums->cover_photo);
            }

            // Simpan foto baru dan konversi ke WebP
            $photo = $request->file('cover_photo');

            // Simpan gambar sementara dengan format asli
            $imagePath = $photo->store('images/album_covers', 'public');

            // Buat gambar dari file yang diupload menggunakan GD
            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

            // Tentukan nama dan path untuk file WebP
            $webpFilename = time() . '.webp';
            $webpPath = 'images/album_covers/' . $webpFilename;
            $webpFullPath = storage_path('app/public/' . $webpPath);

            // Konversi gambar ke WebP dan simpan
            imagewebp($imageResource, $webpFullPath);
            imagedestroy($imageResource);

            // Hapus gambar asli (JPEG/PNG) setelah konversi
            Storage::disk('public')->delete($imagePath);

            // Simpan path file WebP
            $albums->cover_photo = $webpPath;
        }

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
            // Simpan gambar sementara dengan format asli
            $imageName = time() . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('images/galeri-foto', $imageName, 'public');

            // Buat gambar dari file yang diupload menggunakan GD
            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

            // Tentukan nama dan path untuk file WebP
            $webpFilename = time() . '.webp';
            $webpPath = 'images/galeri-foto/' . $webpFilename;
            $webpFullPath = storage_path('app/public/' . $webpPath);

            // Tentukan kualitas WebP (0 - 100, di mana 100 adalah kualitas tertinggi)
            $quality = 50; // Atur kualitas sesuai kebutuhan Anda

            // Konversi gambar ke WebP dengan kualitas yang ditentukan dan simpan
            imagewebp($imageResource, $webpFullPath, $quality);
            imagedestroy($imageResource);

            // Hapus gambar asli (JPEG/PNG) setelah konversi
            Storage::disk('public')->delete($imagePath);

            // Simpan data gambar ke database dengan path WebP
            ImageGallery::create([
                'filename' => $webpFilename,
                'path' => $webpPath,
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
