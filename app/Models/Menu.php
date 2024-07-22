<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'url', 'order', 'parent_id', 'is_active', 'menu_target'];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('is_active', true);
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Menambahkan accessor untuk semua kolom fillable
    protected $appends = ['status', 'nama_menu', 'tautan', 'urutan', 'id_parent', 'menu_aktif', 'target_menu'];

    // Accessor untuk status
    public function getStatusAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Tidak Aktif';
    }

    // Accessor untuk title menjadi nama_menu
    public function getNamaMenuAttribute()
    {
        return $this->title;
    }

    // Accessor untuk url menjadi tautan
    public function getTautanAttribute()
    {
        return $this->url;
    }

    // Accessor untuk order menjadi urutan
    public function getUrutanAttribute()
    {
        return $this->order;
    }

    // Accessor untuk parent_id menjadi id_parent
    public function getIdParentAttribute()
    {
        return $this->parent_id;
    }

    // Accessor untuk is_active menjadi menu_aktif
    public function getMenuAktifAttribute()
    {
        return $this->is_active;
    }

    // Accessor untuk menu_target menjadi target_menu
    public function getTargetMenuAttribute()
    {
        return $this->menu_target;
    }
}
