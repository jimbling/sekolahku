<?php

namespace App\Services\Backend\Media;

use App\Models\File;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FilesServices
{
    public function getIndexData()
    {
        return [
            'judul' => "Media File",
            'files' => File::all(),
            'kategori' => Category::where('category_type', 'file')->get(),
        ];
    }

    public function getFiles(Request $request)
    {
        $files = File::with('category:id,name')->select([
            'id',
            'file_title',
            'file_description',
            'file_name',
            'file_type',
            'file_category_id',
            'file_path',
            'file_ext',
            'file_size',
            'file_counter',
            'file_status',
            'created_at'
        ])->orderBy('created_at', 'desc');

        return DataTables::of($files)
            ->addIndexColumn()
            ->addColumn('category_name', fn($row) => $row->category->name ?? 'N/A')
            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $messages = [
            'file_nama.required'       => 'Judul file wajib diisi.',
            'file_nama.unique'         => 'Judul file sudah digunakan, silakan pilih judul lain.',
            'file_keterangan.required' => 'Keterangan file wajib diisi.',
            'file_kategori.required'   => 'Kategori file wajib dipilih.',
            'file.file'                => 'File yang diunggah tidak valid.',
            'file.mimes'               => 'Format file harus berupa: pdf, doc, docx, xls, xlsx, zip, rar, png, atau jpg.',
            'file.max'                 => 'Ukuran file maksimal 100 MB.',
            'file_url.url'             => 'Link harus berupa URL yang valid (contoh: https://example.com).',
        ];

        $validator = Validator::make($request->all(), [
            'file_nama'       => 'required|unique:files,file_title',
            'file_keterangan' => 'required',
            'file_kategori'   => 'required',
            'file'            => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg|max:102400',
            'file_url'        => 'nullable|url',
        ], $messages);

        if ($validator->fails()) {
            return [
                'errors' => $validator->errors()->toArray()
            ];
        }

        // ✅ Validasi logika: harus salah satu, file atau URL
        if (!$request->hasFile('file') && !$request->filled('file_url')) {
            return [
                'errors' => [
                    'file' => ['Silakan unggah file atau masukkan link URL.']
                ]
            ];
        }

        // ✅ OPSI 1: Upload file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileSlug = Str::slug($request->input('file_nama'));
            $fileName = time() . '_' . $fileSlug . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('files', $fileName, 'public');

            File::create([
                'file_title'       => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_name'        => $fileName,
                'file_type'        => $file->getMimeType(),
                'file_path'        => $filePath,
                'file_url'         => null,
                'file_ext'         => $file->getClientOriginalExtension(),
                'file_size'        => $file->getSize(),
            ]);

            return [
                'success' => '✅ File berhasil diunggah dan disimpan.'
            ];
        }

        // ✅ OPSI 2: Link URL bebas
        if ($request->filled('file_url')) {
            File::create([
                'file_title'       => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_url'         => $request->input('file_url'),
                'file_name'        => null,
                'file_type'        => null,
                'file_path'        => null,
                'file_ext'         => null,
                'file_size'        => null,
            ]);

            return [
                'success' => 'Link berhasil disimpan.'
            ];
        }

        return [
            'errors' => ['Terjadi kesalahan tak terduga.']
        ];
    }





    public function fetchById($id)
    {
        return File::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file_nama'       => 'required',
            'file_keterangan' => 'required',
            'file_kategori'   => 'required',
            'file'            => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg|max:102400',
            'file_status'     => 'required|in:public,private',
            'file_url'        => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->toArray()];
        }

        $file = File::findOrFail($id);
        $oldFilePath = $file->file_path;

        // 🟢 CASE 1: Upload file baru
        if ($request->hasFile('file')) {
            $newFile = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->input('file_nama')) . '.' . $newFile->getClientOriginalExtension();
            $filePath = $newFile->storeAs('files', $fileName, 'public');

            // Hapus file lama kalau ada
            if ($oldFilePath) {
                Storage::disk('public')->delete($oldFilePath);
            }

            $file->update([
                'file_title'       => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_name'        => $fileName,
                'file_type'        => $newFile->getMimeType(),
                'file_path'        => $filePath,
                'file_ext'         => $newFile->getClientOriginalExtension(),
                'file_size'        => $newFile->getSize(),
                'file_status'      => $request->input('file_status'),
                'file_url'         => null // reset URL kalau ada file fisik baru
            ]);

            return ['message' => '✅ File berhasil diperbarui dengan file baru.'];
        }

        // 🟢 CASE 2: Update file URL (tanpa upload file)
        if ($request->filled('file_url')) {
            // Hapus file lama kalau sebelumnya ada file fisik
            if ($oldFilePath) {
                Storage::disk('public')->delete($oldFilePath);
            }

            $file->update([
                'file_title'       => $request->input('file_nama'),
                'file_description' => $request->input('file_keterangan'),
                'file_category_id' => $request->input('file_kategori'),
                'file_status'      => $request->input('file_status'),
                'file_url'         => $request->input('file_url'),
                'file_name'        => null,
                'file_type'        => null,
                'file_path'        => null,
                'file_ext'         => null,
                'file_size'        => null,
            ]);

            return ['message' => 'File berhasil diperbarui dengan URL baru.'];
        }

        // 🟢 CASE 3: Hanya update metadata (judul, keterangan, kategori, status)
        $file->update([
            'file_title'       => $request->input('file_nama'),
            'file_description' => $request->input('file_keterangan'),
            'file_category_id' => $request->input('file_kategori'),
            'file_status'      => $request->input('file_status')
        ]);

        return ['message' => 'Data file berhasil diperbarui.'];
    }


    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete(); // ini otomatis memicu event deleting

        return ['type' => 'success', 'message' => 'File unduhan berhasil dihapus.'];
    }


    public function deleteSelected(array $ids)
    {
        $files = File::whereIn('id', $ids)->get();

        foreach ($files as $file) {
            if ($file->file_path) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        File::destroy($ids);

        return ['type' => 'success', 'message' => 'File unduhan berhasil dihapus.'];
    }
}
