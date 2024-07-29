<?php

namespace App\Imports;

use App\Models\Option;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OptionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Option([
            'id' => $row['id'],
            'option_group' => $row['option_group'],
            'option_name' => $row['option_name'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
