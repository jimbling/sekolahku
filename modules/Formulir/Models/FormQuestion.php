<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
    protected $fillable = [
        'form_id',
        'question_text',
        'type',
        'is_required',
        'sort_order',
        'file_max_size'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function options()
    {
        return $this->hasMany(FormOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class, 'question_id');
    }
}
