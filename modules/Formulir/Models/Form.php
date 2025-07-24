<?php

namespace Modules\Formulir\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug', 'is_active', 'header_image', 'google_sheet_id', 'uuid'];

    public function questions()
    {
        return $this->hasMany(FormQuestion::class);
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }

    protected static function booted()
    {
        static::creating(function ($form) {
            $form->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function themeSetting()
    {
        return $this->hasOne(FormThemeSetting::class);
    }
}
