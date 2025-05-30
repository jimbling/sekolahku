<?php

// app/Services/Backend/Media/SliderService.php
namespace App\Services\Backend\Media;

use App\Models\ImageSlider;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function getAllSliders()
    {
        return ImageSlider::all();
    }

    public function getSlidersForDatatables()
    {
        return ImageSlider::select(['id', 'caption', 'path', 'created_at', 'updated_at']);
    }

    public function storeSlider(array $data)
    {
        $image = $data['sliders_photo'];
        $webpPath = $this->processSliderImage($image);

        return ImageSlider::create([
            'caption' => $data['sliders_caption'],
            'path' => $webpPath,
        ]);
    }

    public function updateSlider(ImageSlider $slider, array $data)
    {
        $slider->caption = $data['sliders_caption'];

        if (isset($data['sliders_photo'])) {
            // Delete old image if exists
            if ($slider->path && Storage::disk('public')->exists($slider->path)) {
                Storage::disk('public')->delete($slider->path);
            }

            $slider->path = $this->processSliderImage($data['sliders_photo']);
        }

        $slider->save();
        return $slider;
    }

    public function deleteSlider(ImageSlider $slider)
    {
        // Delete image file if exists
        if ($slider->path && Storage::disk('public')->exists($slider->path)) {
            Storage::disk('public')->delete($slider->path);
        }

        $slider->delete();
    }

    protected function processSliderImage($image)
    {
        $imagePath = $image->store('images/slider', 'public');
        $imageResource = imagecreatefromstring(file_get_contents(storage_path('app/public/' . $imagePath)));

        $webpPath = str_replace('.' . $image->extension(), '.webp', $imagePath);
        $webpFullPath = storage_path('app/public/' . $webpPath);

        imagewebp($imageResource, $webpFullPath);
        imagedestroy($imageResource);
        Storage::disk('public')->delete($imagePath);

        return $webpPath;
    }
}
