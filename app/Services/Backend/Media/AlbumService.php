<?php

// app/Services/Backend/Media/AlbumService.php
namespace App\Services\Backend\Media;

use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class AlbumService
{
    public function getAllAlbums()
    {
        return Album::all();
    }

    public function getAlbumsForDatatables()
    {
        return Album::select([
            'id',
            'name',
            'description',
            'cover_photo',
            'created_at',
            'updated_at'
        ]);
    }

    public function storeAlbum(array $data)
    {
        $album = new Album();
        $album->name = $data['photos_album'];
        $album->description = $data['photos_keterangan'];

        if (isset($data['cover_photo'])) {
            $album->cover_photo = $this->processCoverPhoto($data['cover_photo']);
        }

        $album->save();
        Session::flash('success', 'Data album baru berhasil ditambahkan!');

        return $album;
    }

    public function updateAlbum(Album $album, array $data)
    {
        $album->name = $data['photos_album'];
        $album->description = $data['photos_keterangan'];

        if (isset($data['cover_photo'])) {
            // Delete old cover photo if exists
            if ($album->cover_photo && Storage::disk('public')->exists($album->cover_photo)) {
                Storage::disk('public')->delete($album->cover_photo);
            }

            $album->cover_photo = $this->processCoverPhoto($data['cover_photo']);
        }

        $album->save();
        return $album;
    }

    public function deleteAlbum(Album $album)
    {
        // Delete related images
        foreach ($album->images as $image) {
            $filePath = storage_path('app/public/' . $image->path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete cover photo if exists
        if ($album->cover_photo && Storage::disk('public')->exists($album->cover_photo)) {
            Storage::disk('public')->delete($album->cover_photo);
        }

        $album->delete();
    }

    public function deleteMultipleAlbums(array $ids)
    {
        $albums = Album::whereIn('id', $ids)->get();

        foreach ($albums as $album) {
            $this->deleteAlbum($album);
        }
    }

    protected function processCoverPhoto($file)
    {
        $imagePath = $file->store('images/album_covers', 'public');
        $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

        $webpFilename = time() . '.webp';
        $webpPath = 'images/album_covers/' . $webpFilename;
        $webpFullPath = storage_path('app/public/' . $webpPath);

        imagewebp($imageResource, $webpFullPath);
        imagedestroy($imageResource);
        Storage::disk('public')->delete($imagePath);

        return $webpPath;
    }
}
