<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'file_title',
        'file_description',
        'file_name',
        'file_type',
        'file_category_id',
        'file_path',
        'file_url',
        'file_ext',
        'file_size',
        'file_counter',
        'file_status'
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'file_category_id');
    }
}
