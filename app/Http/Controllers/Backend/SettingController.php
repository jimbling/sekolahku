<?php

// app/Http/Controllers/Backend/SettingController.php
namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Services\Backend\Pengaturan\SettingService;
use App\Http\Requests\Backend\Pengaturan\SettingUpdateRequest;
use App\Http\Requests\Backend\Pengaturan\SettingUploadRequest;


class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    // Group of similar setting methods
    private function showSettingView($group, $viewName)
    {
        $data = [
            'judul' => "Pengaturan " . ucfirst(str_replace('_', ' ', $group)),
            'setting_group' => $group
        ];

        $settings = $this->settingService->getSettingsByGroup($group);

        return view("admin.pengaturan.$viewName", array_merge($data, compact('settings')));
    }

    public function settingUmum()
    {
        return $this->showSettingView('general', 'umum');
    }

    public function settingDiskusi()
    {
        return $this->showSettingView('discussion', 'diskusi');
    }

    public function settingMedsos()
    {
        return $this->showSettingView('social_account', 'medsos');
    }

    public function settingMembaca()
    {
        return $this->showSettingView('reading', 'membaca');
    }

    public function settingMenulis()
    {
        return $this->showSettingView('writing', 'menulis');
    }

    public function settingMedia()
    {
        return $this->showSettingView('media', 'media');
    }

    public function settingProfileSekolah()
    {
        return $this->showSettingView('school_profile', 'profile');
    }

    public function edit($id)
    {
        $data = $this->settingService->getSettingWithOptions($id);
        return response()->json($data);
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $this->settingService->updateSetting($setting, $request->input('setting_value'));

        return response()->json(['success' => 'Pengaturan berhasil diperbarui']);
    }

    public function upload(SettingUploadRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $this->settingService->uploadSettingImage($setting, $request->file('foto'));

        return back()->with('success', 'File berhasil diunggah');
    }
}
