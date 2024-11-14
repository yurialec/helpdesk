<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function attendant()
    {
        return $this->belongsTo(User::class, 'attendant_id');
    }
}