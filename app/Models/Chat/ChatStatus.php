<?php

namespace App\Models\Chat;

use App\Enums\ChatStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatStatus extends Model
{
    use HasFactory;
    protected $table = 'chat_status';

    protected $casts = [
        'name' => ChatStatusEnum::class,
    ];
}
