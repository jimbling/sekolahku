<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{
    // Menampilkan daftar pengaturan
    public function settingUmum()
    {
        $data = [
            'judul' => "Pengaturan Umum",
            'setting_group' => 'general'
        ];

        $settings = Setting::where('setting_group', 'general')->get();

        return view('admin.pengaturan.umum', array_merge($data, compact('settings')));
    }
    public function settingDiskusi()
    {
        $data = [
            'judul' => "Pengaturan Diskusi",
            'setting_group' => 'discussion'
        ];

        $settings = Setting::where('setting_group', 'discussion')->get();

        return view('admin.pengaturan.diskusi', array_merge($data, compact('settings')));
    }

    public function settingMedsos()
    {
        $data = [
            'judul' => "Pengaturan Medsos",
            'setting_group' => 'social_account'
        ];

        $settings = Setting::where('setting_group', 'social_account')->get();

        return view('admin.pengaturan.medsos', array_merge($data, compact('settings')));
    }

    public function settingMembaca()
    {
        $data = [
            'judul' => "Pengaturan Membaca",
            'setting_group' => 'reading'
        ];

        $settings = Setting::where('setting_group', 'reading')->get();

        return view('admin.pengaturan.membaca', array_merge($data, compact('settings')));
    }
    public function settingMenulis()
    {
        $data = [
            'judul' => "Pengaturan Menulis",
            'setting_group' => 'writing'
        ];

        $settings = Setting::where('setting_group', 'writing')->get();

        return view('admin.pengaturan.menulis', array_merge($data, compact('settings')));
    }
    public function settingMedia()
    {
        $data = [
            'judul' => "Pengaturan Media",
            'setting_group' => 'media'
        ];

        $settings = Setting::where('setting_group', 'media')->get();

        return view('admin.pengaturan.media', array_merge($data, compact('settings')));
    }

    public function settingProfileSekolah()
    {
        $data = [
            'judul' => "Pengaturan Profile Sekolah",
            'setting_group' => 'school_profile'
        ];

        $settings = Setting::where('setting_group', 'school_profile')->get();

        return view('admin.pengaturan.profile', array_merge($data, compact('settings')));
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        // Ambil opsi berdasarkan setting key
        $options = Option::where('option_group', $setting->key)->get();

        return response()->json([
            'setting' => $setting,
            'options' => $options,
        ]);
    }

    // Menyimpan perubahan pengaturan
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->setting_value = $request->input('setting_value');

        // Extract width and height if setting_value contains such attributes
        preg_match('/width="(\d+)"/', $setting->setting_value, $matches_width);
        preg_match('/height="(\d+)"/', $setting->setting_value, $matches_height);

        // Update width and height accordingly
        if ($matches_width && $matches_height) {
            // Modify width and height as needed
            $new_width = '700';
            $new_height = '200';

            // Replace width and height in setting_value
            $setting->setting_value = preg_replace('/width="\d+"/', 'width="' . $new_width . '"', $setting->setting_value);
            $setting->setting_value = preg_replace('/height="\d+"/', 'height="' . $new_height . '"', $setting->setting_value);
        }

        $setting->save();

        return response()->json(['success' => 'Setting updated successfully']);
    }

    public function upload(Request $request, $id)
    {
        // Validasi file upload
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk tipe dan ukuran file
        ]);

        if ($request->file('foto')->isValid()) {
            // Ambil file dari request
            $file = $request->file('foto');

            // Dapatkan ekstensi file
            $extension = $file->getClientOriginalExtension();

            // Buat nama file unik menggunakan timestamp dan extension asli
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // Simpan file dengan nama unik di dalam folder 'public/images/settings'
            $path = $file->storeAs('public/images/settings', $filename);

            // Ambil nama file untuk disimpan dalam database
            $fileNameOnly = basename($path);

            // Ambil setting berdasarkan id yang diterima dari parameter
            $setting = Setting::findOrFail($id);

            // Hapus file lama jika ada
            if (!empty($setting->setting_value)) {
                Storage::delete('public/images/settings/' . $setting->setting_value);
            }

            // Update setting_value dengan nama file baru
            $setting->setting_value = $fileNameOnly;
            $setting->save();

            // Redirect back with success message
            return back()->with('success', 'File uploaded successfully');
        }

        // Jika validasi file gagal
        return back()->withErrors(['error' => 'Invalid file uploaded']);
    }
}
