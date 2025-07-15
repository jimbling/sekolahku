<?php

namespace Modules\Ringkas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RingkasLink extends Model
{
    use HasFactory;

    protected $table = 'ringkas_links';

    protected $fillable = [
        'slug',
        'original_url',
        'description',
        'is_active',
        'hit_count',
        'created_by',
        'expired_at',
    ];

    public function stats()
    {
        return $this->hasMany(RingkasLinkStat::class, 'link_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
