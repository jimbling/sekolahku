<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;

    protected $table = 'image_gallerys';

    protected $fillable = [
        'filename',
        'path',
        'caption',
        'alt_text',
        'is_active',
        'order',
        'album_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Relasi dengan album
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
