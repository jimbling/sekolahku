<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_group',
        'setting_variable',
        'key',
        'settings_name',
        'setting_default_value',
        'setting_access_group',
        'setting_description',
        'modal_type',
    ];

    protected $primaryKey = 'id';
}
