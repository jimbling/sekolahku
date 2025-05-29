<?php

namespace App\Http\Controllers\Backend;

use App\Models\ImageSlider;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageSlidersController extends Controller
{
    public function index()
    {
        $sliders = ImageSlider::all();
        $data = [
            'judul' => "Gambar Slide",
            'gambarSliders' => $sliders,
        ];

        return view('admin.blog.slider', $data);
    }

    public function getSlider(Request $request)
    {
        if ($request->ajax()) {
            $sliders = ImageSlider::select(['id', 'caption', 'path', 'created_at', 'updated_at']);
            return DataTables::of($sliders)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" data-path="' . $row->path . '" class="btn btn-info btn-xs view-btn"><i class="fas fa-eye"></i> Lihat</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function simpanSliders(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'sliders_caption' => 'required|string|max:255',
            'sliders_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ], [
            'sliders_caption.required' => 'Caption harus diisi',
            'sliders_photo.required' => 'File gambar harus diunggah.',
            'sliders_photo.image' => 'File yang diunggah harus berupa gambar.',
            'sliders_photo.mimes' => 'Gambar harus berupa file jpeg, png, jpg, atau gif.',
            'sliders_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Menyimpan file gambar
        if ($request->hasFile('sliders_photo')) {
            $image = $request->file('sliders_photo');
            $imagePath = $image->store('images/slider', 'public');

            // Konversi gambar ke format WebP menggunakan ekstensi GD
            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));
            $webpPath = str_replace('.' . $image->extension(), '.webp', $imagePath);
            $webpFullPath = storage_path('app/public/' . $webpPath);
            imagewebp($imageResource, $webpFullPath);
            imagedestroy($imageResource);

            // Hapus gambar asli jika diperlukan
            Storage::disk('public')->delete($imagePath);
        } else {
            return response()->json(['errors' => ['Gambar tidak diunggah.']], 422);
        }

        // Menyimpan data ke database
        ImageSlider::create([
            'caption' => $request->sliders_caption,
            'path' => $webpPath,
        ]);

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Gambar Slider berhasil ditambahkan.'], 200);
    }

    public function destroy($id)
    {
        $sliders = ImageSlider::findOrFail($id);

        // Hapus kategori
        $sliders->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Gambar Slider berhasil dihapus.'
        ]);
    }

    public function fetchSliderById($id)
    {
        $sliders = ImageSlider::findOrFail($id);
        return response()->json($sliders);
    }

    public function update(Request $request, $id)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'sliders_caption' => 'required|string|max:255',
            'sliders_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional
        ], [
            'sliders_caption.required' => 'Caption harus diisi',
            'sliders_photo.image' => 'File yang diunggah harus berupa gambar.',
            'sliders_photo.mimes' => 'Gambar harus berupa file jpeg, png, jpg, atau gif.',
            'sliders_photo.max' => 'Ukuran gambar maksimum adalah 2MB.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Ambil data slider yang akan diperbarui
        $slider = ImageSlider::findOrFail($id);

        // Update caption jika ada perubahan
        if ($request->has('sliders_caption')) {
            $slider->caption = $request->sliders_caption;
        }

        // Update gambar jika ada unggahan gambar baru
        if ($request->hasFile('sliders_photo')) {
            $image = $request->file('sliders_photo');
            $imagePath = $image->store('images/slider', 'public');

            // Konversi gambar ke format WebP menggunakan ekstensi GD
            $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));
            $webpPath = str_replace('.' . $image->extension(), '.webp', $imagePath);
            $webpFullPath = storage_path('app/public/' . $webpPath);
            imagewebp($imageResource, $webpFullPath);
            imagedestroy($imageResource);

            // Hapus gambar asli jika diperlukan
            Storage::disk('public')->delete($imagePath);

            // Update path gambar ke path WebP
            $slider->path = $webpPath;
        }

        // Simpan perubahan
        $slider->save();

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Gambar Slider berhasil diperbarui.'], 200);
    }
}
