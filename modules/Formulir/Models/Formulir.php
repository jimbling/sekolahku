<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    protected $table = 'formulir';

    protected $fillable = ['nama']; // sesuaikan dengan kolom migrasi
}