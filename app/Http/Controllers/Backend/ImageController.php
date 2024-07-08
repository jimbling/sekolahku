<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/summernote');
            $url = Storage::url($path);

            // Simpan URL gambar ke dalam database
            $image = new Image();
            $image->url = $url;
            $image->save();

            return response()->json($url);
        }
        return response()->json(['error' => 'File not found.'], 404);
    }
}
