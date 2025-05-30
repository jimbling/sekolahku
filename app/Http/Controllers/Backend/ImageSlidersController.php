<?php

// app/Http/Controllers/Backend/ImageSlidersController.php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Media\SliderStoreRequest;
use App\Http\Requests\Backend\Media\SliderUpdateRequest;
use App\Models\ImageSlider;
use App\Services\Backend\Media\SliderService;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ImageSlidersController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index()
    {
        $sliders = $this->sliderService->getAllSliders();
        $data = [
            'judul' => "Gambar Slide",
            'gambarSliders' => $sliders,
        ];

        return view('admin.blog.slider', $data);
    }

    public function getSlider(Request $request)
    {
        if ($request->ajax()) {
            $sliders = $this->sliderService->getSlidersForDatatables();

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

    public function simpanSliders(SliderStoreRequest $request)
    {
        $this->sliderService->storeSlider($request->all());

        return response()->json(['message' => 'Gambar Slider berhasil ditambahkan.'], 200);
    }

    public function destroy($id)
    {
        $slider = ImageSlider::findOrFail($id);
        $this->sliderService->deleteSlider($slider);

        return response()->json([
            'type' => 'success',
            'message' => 'Gambar Slider berhasil dihapus.'
        ]);
    }

    public function fetchSliderById($id)
    {
        $slider = ImageSlider::findOrFail($id);
        return response()->json($slider);
    }

    public function update(SliderUpdateRequest $request, $id)
    {
        $slider = ImageSlider::findOrFail($id);
        $this->sliderService->updateSlider($slider, $request->all());

        return response()->json(['message' => 'Gambar Slider berhasil diperbarui.'], 200);
    }
}
