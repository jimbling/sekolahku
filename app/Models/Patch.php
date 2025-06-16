<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patch extends Model
{
    protected $fillable = [
        'name',
        'version',
        'description',
        'installed_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'installed_at' => 'datetime',
    ];

    public function getInstalledAtWibAttribute()
    {
        return Carbon::parse($this->installed_at)->timezone('Asia/Jakarta');
    }
}
