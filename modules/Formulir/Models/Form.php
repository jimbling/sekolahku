<?php

namespace Modules\Formulir\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug', 'is_active', 'header_image', 'google_sheet_id', 'uuid', 'user_id'];

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

    public function answers()
    {
        return $this->hasManyThrough(
            FormAnswer::class,     // target akhir
            FormResponse::class,   // perantara
            'form_id',             // foreign key di FormResponse
            'response_id',         // foreign key di FormAnswer
            'id',                  // local key di Form
            'id'                   // local key di FormResponse
        );
    }

    public function uploads()
    {
        return $this->hasManyThrough(
            FormUpload::class,
            FormResponse::class,
            'form_id',
            'response_id',
            'id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
