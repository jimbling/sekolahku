<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::all();
        $data = [
            'judul' => "Tautan Ramah",
            'urls' => $urls
        ];

        return view('admin.ringkas_url', $data, compact('urls'));
    }

    public function getUrls(Request $request)
    {
        if ($request->ajax()) {
            // Menambahkan orderBy untuk mengurutkan berdasarkan created_at secara descending
            $urls = Url::select(['id', 'nama_url', 'url_asli', 'url_ringkas', 'created_at'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($urls)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    // Memproses pembuatan URL singkat
    public function shorten(Request $request)
    {
        $request->validate([
            'url_asli' => 'required|url',
            'nama_url' => 'nullable|string|max:255',
        ]);

        // Membuat kode URL singkat yang unik
        $url_ringkas = substr(md5(uniqid()), 0, 6);

        // Simpan data ke database
        $url = Url::create([
            'nama_url' => $request->input('nama_url'),
            'url_asli' => $request->input('url_asli'),
            'url_ringkas' => $url_ringkas,
        ]);

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Tautan ramah berhasil dibuat'
        ]);
    }

    public function update(Request $request, $id)
    {
        // Definisikan aturan validasi dengan pesan khusus
        $validator = Validator::make($request->all(), [
            'nama_url' => 'required|string|max:255',
            'url_asli' => 'required|string|max:255',
            'url_ringkas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9]+$/',
                Rule::unique('urls', 'url_ringkas')->ignore($id),
            ],
        ], [
            'nama_url.required' => 'Judul Tautan wajib diisi.',
            'nama_url.string' => 'Judul Tautan harus berupa teks.',
            'nama_url.max' => 'Judul Tautan tidak boleh lebih dari 255 karakter.',

            'url_asli.required' => 'Tautan Asli wajib diisi.',
            'url_asli.string' => 'Tautan Asli harus berupa teks.',
            'url_asli.max' => 'Tautan Asli tidak boleh lebih dari 255 karakter.',

            'url_ringkas.required' => 'Tautan Ramah wajib diisi.',
            'url_ringkas.string' => 'Tautan Ramah harus berupa teks.',
            'url_ringkas.max' => 'Tautan Ramah tidak boleh lebih dari 255 karakter.',
            'url_ringkas.regex' => 'Tautan Ramah hanya boleh berisi karakter alfanumerik (huruf dan angka tanpa spasi atau simbol).',
            'url_ringkas.unique' => 'Tautan Ramah sudah digunakan, silakan pilih yang lain.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $urls = Url::findOrFail($id);
        $urls->nama_url = $request->nama_url;
        $urls->url_asli = $request->url_asli;
        $urls->url_ringkas = $request->url_ringkas;
        $urls->save();

        return response()->json(['message' => 'Tautan Ramah berhasil diperbarui.']);
    }




    public function fetchUrlsById($id)
    {
        $urls = Url::findOrFail($id);
        return response()->json($urls);
    }

    // Meng-handle redirect dari URL singkat ke URL asli
    public function redirect($shortenedUrl)
    {
        // Cari URL singkat di database
        $url = Url::where('url_ringkas', $shortenedUrl)->firstOrFail();

        // Redirect ke URL asli
        return redirect()->to($url->url_asli);
    }

    public function destroy($id)
    {
        $urls = Url::findOrFail($id);

        // Hapus kategori
        $urls->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Tautan ramah berhasil dihapus.'
        ]);
    }

    public function deleteSelectedUrls(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            // Lakukan validasi atau operasi penghapusan di sini
            // Contoh validasi: pastikan id yang dikirim adalah array dan bukan kosong

            if (!empty($ids)) {
                Url::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Tautan ramah berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Tautan ramah yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }

    // UNTUK FITUR API URL RINGKAS, BISA DIAKTIFKAN KETIKA SUDAH DIHOSTING
    // public function getAllUrls()
    // {
    //     $urls = Url::all(); // Mengambil semua data dari tabel `urls`
    //     return response()->json($urls); // Mengembalikan data dalam bentuk JSON
    // }
}
