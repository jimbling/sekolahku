<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['academic_year', 'semester', 'current_semester'];

    public function rombonganBelajars()
    {
        return $this->hasMany(RombonganBelajar::class);
    }

    // Menambahkan accessor untuk semua kolom fillable
    protected $appends = ['tahun_ajaran', 'status_semester'];


    public function getTahunAjaranAttribute()
    {
        return $this->academic_year;
    }

    public function getStatusSemesterAttribute()
    {
        return $this->current_semester == 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
