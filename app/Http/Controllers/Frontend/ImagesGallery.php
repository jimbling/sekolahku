<?php

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
        $cacheEnabled = get_setting('site_cache', false);
        $albumsPerPage = $this->get_setting_int('albums_per_page', 9);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $albumsCacheKey = "albums_page_" . $request->get('page', 1);

        if ($cacheEnabled) {
            Cache::forget($albumsCacheKey);
        }

        $albums = $cacheEnabled
            ? Cache::remember($albumsCacheKey, now()->addMinutes($cacheTime), function () use ($albumsPerPage) {
                return Album::withCount('images')
                    ->orderBy('created_at', 'desc')
                    ->paginate($albumsPerPage)
                    ->through(function ($album) {
                        $coverPhotoPath = $album->cover_photo ? asset('storage/' . $album->cover_photo) : asset('path/to/default-thumbnail.jpg');
                        $album->coverPhotoPath = $coverPhotoPath;
                        return $album;
                    });
            })
            : Album::withCount('images')
            ->orderBy('created_at', 'desc')
            ->paginate($albumsPerPage)
            ->through(function ($album) {
                $coverPhotoPath = $album->cover_photo ? asset('storage/' . $album->cover_photo) : asset('path/to/default-thumbnail.jpg');
                $album->coverPhotoPath = $coverPhotoPath;
                return $album;
            });

        $judul = 'Galeri Foto';

        return theme_view('konten.galeri_foto', compact('albums', 'judul'));
        // return view('web.galeri_foto', compact('albums', 'judul'));
    }



    public function searchAlbums(Request $request)
    {
        $keywords = $request->input('keywords');

        $albums = Album::where(function ($query) use ($keywords) {
            $query->where('name', 'like', '%' . $keywords . '%')
                ->orWhere('description', 'like', '%' . $keywords . '%');
        })
            ->paginate(5);

        $data = [
            'judul' => "Hasil Pencarian Album: " . $keywords,
            'albums' => $albums,
        ];

        return theme_view('konten.galeri_foto',  $data);
        // return view('web.galeri_foto', $data);
    }




    public function show($id)
    {
        $album = Album::with('images')->findOrFail($id);

        $data = [
            'judul' => $album->name,
            'album' => $album,
        ];

        return theme_view('konten.album_foto',  $data);
        // return view('web.album_foto', $data);
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
