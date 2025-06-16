<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    protected $fillable = [
        'version',
        'changelog',
        'applied_at',
    ];

    protected $dates = ['applied_at'];
    protected $casts = [
        'applied_at' => 'datetime',
    ];
}
