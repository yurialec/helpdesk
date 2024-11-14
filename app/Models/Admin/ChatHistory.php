<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;
    protected $table = 'chat_history';

    protected $fillable = [
        'client_id',
    ];
}
