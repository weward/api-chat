<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chat_logs';

    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany('App\Models\ChatMessage');
    }
}
