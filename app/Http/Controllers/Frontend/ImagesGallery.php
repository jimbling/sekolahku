<?php

// app/Http/Controllers/Frontend/ImagesGallery.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ImagesGallery extends Controller
{
    private function get_setting_int($key, $default = 0)
    {
        $value = get_setting($key, $default);
        return is_numeric($value) ? (int) $value : $default;
    }

    public function index(Request $request)
    {
        $cacheEnabled = get_setting('site_cache', false); // Mengambil pengaturan cache
        $albumsPerPage = $this->get_setting_int('albums_per_page', 9); // Mengambil jumlah album per halaman
        $cacheTime = $this->get_setting_int('site_cache_time', 10); // Mengambil waktu cache
        $albumsCacheKey = "albums_page_" . $request->get('page', 1); // Membuat kunci cache berdasarkan halaman

        if ($cacheEnabled) {
            Cache::forget($albumsCacheKey); // Hapus cache jika cache diaktifkan
        }

        $albums = $cacheEnabled
            ? Cache::remember($albumsCacheKey, now()->addMinutes($cacheTime), function () use ($albumsPerPage) {
                return Album::withCount('images') // Menghitung jumlah gambar per album
                    ->orderBy('created_at', 'desc')
                    ->paginate($albumsPerPage)
                    ->through(function ($album) {
                        // Tentukan path gambar sampul
                        $coverPhotoPath = $album->cover_photo ? asset('storage/' . $album->cover_photo) : asset('path/to/default-thumbnail.jpg');
                        $album->coverPhotoPath = $coverPhotoPath; // Tambahkan path gambar sampul ke album
                        return $album;
                    });
            })
            : Album::withCount('images') // Menghitung jumlah gambar per album
            ->orderBy('created_at', 'desc')
            ->paginate($albumsPerPage)
            ->through(function ($album) {
                // Tentukan path gambar sampul
                $coverPhotoPath = $album->cover_photo ? asset('storage/' . $album->cover_photo) : asset('path/to/default-thumbnail.jpg');
                $album->coverPhotoPath = $coverPhotoPath; // Tambahkan path gambar sampul ke album
                return $album;
            });

        $judul = 'Galeri Foto'; // Judul halaman

        return view('web.galeri_foto', compact('albums', 'judul'));
    }



    public function searchAlbums(Request $request)
    {
        $keywords = $request->input('keywords');

        // Mencari album berdasarkan name dan description
        $albums = Album::where(function ($query) use ($keywords) {
            $query->where('name', 'like', '%' . $keywords . '%')
                ->orWhere('description', 'like', '%' . $keywords . '%');
        })
            ->paginate(5);

        $data = [
            'judul' => "Hasil Pencarian Album: " . $keywords,
            'albums' => $albums,
        ];

        return view('web.galeri_foto', $data);
    }




    public function show($id)
    {
        $album = Album::with('images')->findOrFail($id);

        $data = [
            'judul' => $album->name,
            'album' => $album,
        ];

        return view('web.album_foto', $data);
    }

    public function photos($id)
    {
        $album = Album::with('images')->findOrFail($id);
        $photos = $album->images->map(function ($image) {
            return [
                'path' => asset('storage/' . $image->path),
                'caption' => $image->caption,
            ];
        });

        return response()->json(['photos' => $photos]);
    }
}
