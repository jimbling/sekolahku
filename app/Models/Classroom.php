<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rombonganBelajars()
    {
        return $this->hasMany(RombonganBelajar::class);
    }

    // Menambahkan accessor untuk semua kolom fillable
    protected $appends = ['nama_kelas'];


    public function getNamaKelasAttribute()
    {
        return $this->name;
    }
}
