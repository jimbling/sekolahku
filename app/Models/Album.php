<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi dengan gambar
    public function images()
    {
        return $this->hasMany(ImageGallery::class);
    }
}
