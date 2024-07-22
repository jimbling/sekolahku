<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model
{
    use HasFactory;

    protected $fillable = ['academic_years_id', 'classroom_id', 'gtks_id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_years_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function gtk()
    {
        return $this->belongsTo(Gtk::class, 'gtks_id');
    }

    public function anggotaRombels()
    {
        return $this->hasMany(AnggotaRombel::class, 'rombel_id');
    }

    // Menambahkan accessor untuk menghitung jumlah anggota
    public function getJumlahAnggotaAttribute()
    {
        return $this->anggotaRombels()->count();
    }

    // Menambahkan accessor untuk semua kolom fillable
    protected $appends = ['tahun_ajaran', 'kelas', 'wali_kelas', 'jumlah_anggota'];

    public function getTahunAjaranAttribute()
    {
        return $this->academicYear ? $this->academicYear->academic_year : 'N/A';
    }

    public function getKelasAttribute()
    {
        return $this->classroom ? $this->classroom->name : 'N/A';
    }

    public function getWaliKelasAttribute()
    {
        return $this->gtk ? $this->gtk->full_name : 'N/A';
    }
}
