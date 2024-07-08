<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
        'quote', 'quote_by',
    ];

    public static function getAllQuote()
    {
        return Quote::all();
    }
}
