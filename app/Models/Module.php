<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Module.php
class Module extends Model
{
    protected $fillable = [
        'name',
        'alias',
        'version',
        'description',
        'enabled'
    ];
}
