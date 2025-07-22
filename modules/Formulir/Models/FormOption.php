<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class FormOption extends Model
{
    protected $fillable = ['question_id', 'option_text', 'sort_order'];

    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'question_id');
    }
}
