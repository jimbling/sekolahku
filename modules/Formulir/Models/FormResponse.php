<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = ['form_id'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class, 'response_id');
    }

    public function uploads()
    {
        return $this->hasMany(FormUpload::class, 'response_id');
    }
}
