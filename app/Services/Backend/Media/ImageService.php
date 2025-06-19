<?php

// app/Services/Backend/Media/ImageService.php
namespace App\Services\Backend\Media;

use Illuminate\Support\Str;
use App\Models\ImageGallery;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function storeImages($albumId, array $files, array $data)
    {
        $images = [];

        foreach ($files as $index => $file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueId = Str::uuid()->toString(); // atau Str::uuid()->toString();

            $imageName = $uniqueId . '_' . $originalName . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('images/galeri-foto', $imageName, 'public');

            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

            $webpFilename = $uniqueId . '.webp';
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
