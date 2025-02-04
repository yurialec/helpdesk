<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;
    protected $table = 'chat_history';

    protected $fillable = [
        'chat_id',
        'client_id',
        'started_at',
        'user_id',
        'activated_at',
        'finished_at',
        'finished_by',
    ];
}
