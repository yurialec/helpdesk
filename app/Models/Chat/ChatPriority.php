<?php

namespace App\Models\Chat;

use App\Enums\ChatPriorityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatPriority extends Model
{
    use HasFactory;

    protected $table = 'chat_priority';

    protected $casts = [
        'name' => ChatPriorityEnum::class,
    ];
}
