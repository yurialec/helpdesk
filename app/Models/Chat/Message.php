<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}
