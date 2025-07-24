<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = ['name', 'slug', 'url'];
}
