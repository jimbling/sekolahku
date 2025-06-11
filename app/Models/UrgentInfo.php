<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgentInfo extends Model
{
    protected $fillable = ['title', 'message', 'start_date', 'end_date', 'url'];
}
