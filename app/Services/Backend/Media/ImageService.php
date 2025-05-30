<?php

// app/Services/Backend/Media/ImageService.php
namespace App\Services\Backend\Media;

use App\Models\ImageGallery;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function storeImages($albumId, array $files, array $data)
    {
        $images = [];

        foreach ($files as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('images/galeri-foto', $imageName, 'public');

            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

            $webpFilename = time() . '.webp';
            $webpPath = 'images/galeri-foto/' . $webpFilename;
            $webpFullPath = storage_path('app/public/' . $webpPath);

            imagewebp($imageResource, $webpFullPath, 50);
            imagedestroy($imageResource);
            Storage::disk('public')->delete($imagePath);

            $images[] = ImageGallery::create([
                'filename' => $webpFilename,
                'path' => $webpPath,
                'caption' => $data['caption'] ?? '',
                'alt_text' => $data['alt_text'] ?? '',
                'is_active' => true,
                'order' => $data['order'] ?? 0,
                'album_id' => $albumId,
            ]);
        }

        return $images;
    }

    public function deleteImage(ImageGallery $image)
    {
        $filePath = storage_path('app/public/' . $image->path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $image->delete();
    }
}
