<?php

namespace Modules\Formulir\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    protected $fillable = ['response_id', 'question_id', 'answer'];

    public function response()
    {
        return $this->belongsTo(FormResponse::class, 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'question_id');
    }
}
