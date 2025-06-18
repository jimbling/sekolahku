<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nis',
        'birth_place',
        'birth_date',
        'gender',
        'email',
        'student_status_id',
        'photo',
        'end_date',
        'reason',
        'is_alumni',
        'tahun_lulus',
        'alamat',
        'no_hp'
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_student');
    }

    public function anggotaRombels()
    {
        return $this->hasMany(AnggotaRombel::class);
    }

    // Menambahkan accessor untuk semua kolom fillable
    protected $appends = ['nama_lengkap', 'no_induk', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'email_aktif', 'status', 'foto_siswa', 'tanggal_keluar', 'alasan_keluar'];


    public function getStatusAttribute()
    {
        return $this->student_status_id ? 'Aktif' : 'Tidak Aktif';
    }

    public function getNoIndukAttribute()
    {
        return $this->nis;
    }


    public function getNamaLengkapAttribute()
    {
        return $this->name;
    }


    public function getTempatLahirAttribute()
    {
        return $this->birth_place;
    }


    public function getTanggalLahirAttribute()
    {
        return $this->birth_date;
    }


    public function getJenisKelaminAttribute()
    {
        return $this->gender;
    }


    public function getEmailAktifAttribute()
    {
        return $this->email;
    }


    public function getFotoSiswaAttribute()
    {
        return $this->photo;
    }


    public function getTanggalKeluarAttribute()
    {
        return $this->end_date;
    }


    public function getAlasanKeluarAttribute()
    {
        return $this->reason;
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
