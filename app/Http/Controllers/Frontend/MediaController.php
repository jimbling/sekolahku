<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Carbon\Carbon;

Carbon::setLocale('id');

class MediaController extends Controller
{
    // Fungsi untuk format ukuran file
    public static function formatFileSize($sizeInBytes)
    {
        if ($sizeInBytes >= 1073741824) {
            return number_format($sizeInBytes / 1073741824, 2) . ' GB';
        } elseif ($sizeInBytes >= 1048576) {
            return number_format($sizeInBytes / 1048576, 2) . ' MB';
        } elseif ($sizeInBytes >= 1024) {
            return number_format($sizeInBytes / 1024, 2) . ' KB';
        } elseif ($sizeInBytes > 1) {
            return $sizeInBytes . ' bytes';
        } elseif ($sizeInBytes == 1) {
            return $sizeInBytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    public function unduhan()
    {
        $files = File::where('file_status', 'public')
            ->latest()
            ->paginate(5);

        // Format ukuran file
        foreach ($files as $file) {
            $file->formatted_size = self::formatFileSize($file->file_size);
        }

        $data = [
            'judul' => "Media File",
            'files' => $files,
        ];

        return theme_view('konten.unduhan', $data);
        // return view('web.unduhan', $data);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');

        $files = File::where('file_status', 'public')
            ->where(function ($query) use ($keywords) {
                $query->where('file_title', 'like', '%' . $keywords . '%')
                    ->orWhere('file_description', 'like', '%' . $keywords . '%');
            })
            ->paginate(5);

        $data = [
            'judul' => "Hasil Pencarian: " . $keywords,
            'files' => $files,
        ];

        return theme_view('konten.unduhan', $data);
        // return view('web.unduhan', $data);
    }

    public function unduhFile($id)
    {
        $file = File::findOrFail($id);
        $file->increment('file_counter');

        return response()->download(storage_path('app/public/' . $file->file_path), $file->file_name);
    }
}
