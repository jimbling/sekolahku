<?php
// app/Services/Backend/Setting/SettingService.php
namespace App\Services\Backend\Pengaturan;

use App\Models\Setting;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function getSettingsByGroup($group)
    {
        return Setting::where('setting_group', $group)->get();
    }

    public function getSettingWithOptions($id)
    {
        $setting = Setting::findOrFail($id);
        $options = Option::where('option_group', $setting->key)->get();

        return [
            'setting' => $setting,
            'options' => $options,
        ];
    }

    public function updateSetting(Setting $setting, $value)
    {
        $setting->setting_value = $value;

        // Extract and modify width/height if present
        preg_match('/width="(\d+)"/', $setting->setting_value, $matches_width);
        preg_match('/height="(\d+)"/', $setting->setting_value, $matches_height);

        if ($matches_width && $matches_height) {
            $new_width = '700';
            $new_height = '200';

            $setting->setting_value = preg_replace('/width="\d+"/', 'width="' . $new_width . '"', $setting->setting_value);
            $setting->setting_value = preg_replace('/height="\d+"/', 'height="' . $new_height . '"', $setting->setting_value);
        }

        $setting->save();

        return $setting;
    }

    public function uploadSettingImage(Setting $setting, $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs('public/images/settings', $filename);

        // Delete old file if exists
        if (!empty($setting->setting_value)) {
            Storage::delete('public/images/settings/' . $setting->setting_value);
        }

        $setting->setting_value = basename($path);
        $setting->save();

        return $setting;
    }
}
