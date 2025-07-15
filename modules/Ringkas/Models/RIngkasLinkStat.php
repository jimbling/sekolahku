<?php

namespace Modules\Ringkas\Models;

use Illuminate\Database\Eloquent\Model;

class RingkasLinkStat extends Model
{
    protected $table = 'ringkas_link_stats';

    public $timestamps = false;

    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'clicked_at',
    ];

    public function link()
    {
        return $this->belongsTo(RingkasLink::class, 'link_id');
    }
}
