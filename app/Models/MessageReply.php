<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id', 'reply', 'reply_by'
    ];
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
