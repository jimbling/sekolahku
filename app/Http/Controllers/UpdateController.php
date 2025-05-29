<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;
use Illuminate\Support\Str;

class UpdateController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'domain' => 'required|string|unique:applications,domain',
        ]);

        $app = Application::create([
            'app_id' => 'jblabs-' . Str::random(10),
            'name' => $request->name,
            'domain' => $request->domain,
        ]);

        return response()->json([
            'message' => 'Aplikasi berhasil terdaftar!',
            'application' => $app,
        ], 201);
    }

    public function latestUpdate()
    {
        // Ambil update terbaru berdasarkan release_date dan created_at, serta load relasi application
        $update = Update::with('application')
            ->latest('release_date')
            ->latest('created_at')
            ->first();

        if (!$update) {
            return response()->json(["message" => "Tidak ada update tersedia"], 200);
        }

        return response()->json($update);
    }



    public function index()
    {
        $judul = 'SMARTY - Updates';
        $updates = Update::orderBy('release_date', 'desc')->get();
        return view('admin.updates', compact('updates', 'judul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required|string|unique:updates',
            'changelog' => 'required|string',
            'file_path' => 'required|string',
            'release_date' => 'required|date',
        ]);

        $update = Update::create($request->all());

        return response()->json(['message' => 'Update berhasil ditambahkan', 'data' => $update], 201);
    }

    /**
     * Menghapus update berdasarkan ID
     */
    public function destroy($id)
    {
        $update = Update::find($id);

        if (!$update) {
            return response()->json(['message' => 'Update tidak ditemukan'], 404);
        }

        $update->delete();
        return response()->json(['message' => 'Update berhasil dihapus']);
    }

    public function download($id)
    {
        $update = Update::findOrFail($id); // Cari data berdasarkan ID

        // Pastikan file ada
        if (!Storage::exists($update->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::download($update->file_path, 'update-v' . $update->version . '.zip');
    }
}
