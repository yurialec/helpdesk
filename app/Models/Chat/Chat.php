<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';

    protected $fillable = [
        'protocol',
        'client_id',
        'user_id',
        'chat_status_id',
        'ended_at',
        'ended_at',
        'ended_at',
        'finished_id',
        'is_client_finished',
        'created_at',
        'updated_at',
    ];
}
