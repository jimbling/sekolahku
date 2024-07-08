<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'link_title', 'link_url', 'link_target', 'link_image', 'link_type'
    ];

    public static function getAllLink()
    {
        return Link::all();
    }
}
