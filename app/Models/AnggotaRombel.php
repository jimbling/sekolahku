<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaRombel extends Model
{
    use HasFactory;

    protected $fillable = ['rombel_id', 'student_id'];

    public function rombel()
    {
        return $this->belongsTo(RombonganBelajar::class, 'rombel_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
