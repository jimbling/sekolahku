<?php

// app/Models/School.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'school_uuid',
        'name',
        'npsn',
        'email',
        'address',
        'license_key',
        'license_status',
        'valid_until',
        'domain'
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];
}
