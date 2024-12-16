<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $with = ['client'];
    protected $fillable = [
        'message',
        'attachment',
        'user_id',
        'client_id',
        'chat_id',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
