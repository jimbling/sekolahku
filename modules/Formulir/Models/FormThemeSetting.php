<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class FormThemeSetting extends Model
{
    protected $fillable = ['form_id', 'pattern_url', 'background_color'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
