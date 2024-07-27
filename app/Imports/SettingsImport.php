<?php

namespace App\Imports;

use App\Models\Setting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SettingsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Setting([
            'id' => $row['id'],
            'setting_group' => $row['setting_group'],
            'key' => $row['key'],
            'settings_name' => $row['settings_name'],
            'setting_value' => $row['setting_value'],
            'setting_default_value' => $row['setting_default_value'],
            'setting_access_group' => $row['setting_access_group'],
            'setting_description' => $row['setting_description'],
            'modal_type' => $row['modal_type'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
