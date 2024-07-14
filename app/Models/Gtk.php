<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gtk extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'gender',
        'parent_school_status',
        'gtk_status',
        'email',
        'photo',
    ];
}
