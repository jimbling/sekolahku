<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'file_status',
        'slug'
    ];

    public static function boot()
    {
        parent::boot();


        static::deleting(function ($file) {
            if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        });


        static::creating(function ($file) {
            if (empty($file->slug)) {
                $file->slug = Str::slug($file->file_title);
            }
        });


        static::updating(function ($file) {
            if ($file->isDirty('file_title')) {
                $file->slug = Str::slug($file->file_title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'file_category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
