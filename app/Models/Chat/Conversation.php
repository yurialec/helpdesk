<?php

namespace App\Models\Chat;

use App\Models\Admin\Client;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chatHistories()
    {
        return $this->hasMany(ChatHistory::class);
    }
}
