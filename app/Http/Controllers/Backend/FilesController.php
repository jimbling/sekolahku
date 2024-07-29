<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;


use App\Models\File;
use App\Models\Category;

use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class FilesController extends Controller
{
    public function index()
    {
        $files = File::all();
        $categories = Category::where('category_type', 'file')->get();
        $data = [
            'judul' => "Media File",
            'files' => $files,
            'kategori' => $categories,
        ];

        return view('admin.media.all_files', $data);
    }

    public function getFiles(Request $request)
    {
        if ($request->ajax()) {
            $files = File::with('category:id,name')
                ->select([
                    'id', 'file_title', 'file_description', 'file_name', 'file_type',
                    'file_category_id', 'file_path', 'file_ext', 'file_size', 'file_counter', 'file_status', 'created_at'
                ])
                ->orderBy('created_at', 'desc'); // Menambahkan urutan berdasarkan created_at terbaru

            return DataTables::of($files)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
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


    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'file_nama' => 'required',
            'file_keterangan' => 'required',
            'file_kategori' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg'
        ], [
            'file_nama.required' => 'Nama file harus diisi.',
            'file_keterangan.required' => 'Keterangan file harus diisi.',
            'file_kategori.required' => 'Kategori file harus diisi.',
            'file.required' => 'File harus diunggah.',
            'file.mimes' => 'Jenis file tidak valid.'
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()], 422);
        }


        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileSlug = Str::slug($request->input('file_nama'));
            $fileName = time() . '_' . $fileSlug . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('files', $fileName, 'public');
            $fileType = $file->getMimeType();
            $fileExt = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
        } else {
            return response()->json(['errors' => ['File tidak ditemukan.']], 422);
        }


        File::create([
            'file_title' => $request->input('file_nama'),
            'file_description' => $request->input('file_keterangan'),
            'file_category_id' => $request->input('file_kategori'),
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_path' => $filePath,
            'file_ext' => $fileExt,
            'file_size' => $fileSize,
        ]);

        return response()->json([
            'success' => 'Data File berhasil ditambahkan.',
            'redirect' => route('files.all') // URL redirect setelah operasi berhasil
        ]);
    }

    public function fetchFilesById($id)
    {
        $files = File::findOrFail($id);

        return response()->json($files);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'file_nama' => 'required',
            'file_keterangan' => 'required',
            'file_kategori' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg',
            'file_status' => 'required|in:public,private'
        ], [
            'file_nama.required' => 'Nama file harus diisi.',
            'file_keterangan.required' => 'Keterangan file harus diisi.',
            'file_kategori.required' => 'Kategori file harus diisi.',
            'file.mimes' => 'Jenis file tidak valid.',
            'file_status.required' => 'Status file harus diisi.',
            'file_status.in' => 'Status file tidak valid.'
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $file = File::findOrFail($id);
        $oldFilePath = $file->file_path;

        // Mengunggah file baru jika ada
        if ($request->hasFile('file')) {
            $newFile = $request->file('file');
            $fileSlug = Str::slug($request->input('file_nama'));
            $fileName = time() . '_' . $fileSlug . '.' . $newFile->getClientOriginalExtension();
            $filePath = $newFile->storeAs('files', $fileName, 'public');
            $fileType = $newFile->getMimeType();
            $fileExt = $newFile->getClientOriginalExtension();
            $fileSize = $newFile->getSize();

            // Hapus file lama dari storage
            Storage::disk('public')->delete($oldFilePath);

            // Update data file
            $file->update([
                'file_title' => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_path' => $filePath,
                'file_ext' => $fileExt,
                'file_size' => $fileSize,
                'file_status' => $request->input('file_status'), // Menyimpan file_status
            ]);
        } else {
            // Update data tanpa mengganti file
            $file->update([
                'file_title' => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_status' => $request->input('file_status'), // Menyimpan file_status
            ]);
        }

        return response()->json([
            'message' => 'Data File berhasil diperbarui.', // Pastikan properti 'message' ada di respons
            'redirect' => route('files.all') // URL redirect setelah operasi berhasil
        ]);
    }



    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Hapus file fisik dari storage
        Storage::disk('public')->delete($file->file_path);

        // Hapus entri dari database
        $file->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'File unduhan berhasil dihapus.'
        ]);
    }

    public function deleteSelectedFiles(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                // Mengambil file paths yang akan dihapus
                $filesToDelete = File::whereIn('id', $ids)->get();

                // Hapus file fisik dari storage
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->file_path);
                }

                // Hapus entri dari database
                File::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'File unduhan berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada File yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }
}
