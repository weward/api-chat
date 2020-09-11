<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $guarded = [];

    public function chatLog()
    {
        return $this->belongsTo('App\Models\ChatLog');
    }
}
