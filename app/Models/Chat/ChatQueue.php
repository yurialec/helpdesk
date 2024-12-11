<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatQueue extends Model
{
    use HasFactory;

    protected $table = 'chat_queue';

    protected $fillable = [
        'user_id',
        'chat_id',
        'priority_id',
    ];

    public function priority()
    {
        return $this->belongsTo(ChatPriority::class, 'priority_id')->withDefault();
    }
}
