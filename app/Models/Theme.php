<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes'; // kalau nama tabelnya bukan 'themes' otomatis

    protected $fillable = [
        'theme_name',
        'folder_name',
        'display_name',
        'description',
        'author',
        'version',
        'is_active',
    ];

    // Scope untuk tema aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
