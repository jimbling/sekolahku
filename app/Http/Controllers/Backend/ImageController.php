<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $postTitle = $request->input('post_title') ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = \Illuminate\Support\Str::slug($postTitle);

            $filename = $slug . '-' . time() . '.webp';

            $mime = $file->getMimeType();

            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $imageResource = imagecreatefromjpeg($file->getPathname());
                    break;
                case 'image/png':
                    $imageResource = imagecreatefrompng($file->getPathname());

                    imagepalettetotruecolor($imageResource);
                    imagealphablending($imageResource, true);
                    imagesavealpha($imageResource, true);
                    break;
                case 'image/gif':
                    $imageResource = imagecreatefromgif($file->getPathname());
                    break;
                default:
                    return response()->json(['error' => 'Unsupported image type.'], 415);
            }

            $savePath = storage_path('app/public/summernote/' . $filename);
            imagewebp($imageResource, $savePath, 80);
            imagedestroy($imageResource);
            $url = Storage::url('public/summernote/' . $filename);

            $image = new Image();
            $image->url = $url;
            $image->save();

            return response()->json($url);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
