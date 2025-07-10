<?php

namespace App\Imports;

use App\Models\Setting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class SettingsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan data kosong tidak diproses
        if (empty($row['id']) || empty($row['key'])) {
            return null;
        }

        return Setting::updateOrCreate(
            ['id' => $row['id']], // Atau gunakan 'key' jika lebih cocok
            [
                'setting_group' => $row['setting_group'],
                'key' => $row['key'],
                'settings_name' => $row['settings_name'],
                'setting_value' => $row['setting_value'],
                'setting_default_value' => $row['setting_default_value'],
                'setting_access_group' => $row['setting_access_group'],
                'setting_description' => $row['setting_description'],
                'modal_type' => $row['modal_type'],
                'created_at' => Carbon::parse($row['created_at']),
                'updated_at' => Carbon::parse($row['updated_at']),
            ]
        );
    }
}
