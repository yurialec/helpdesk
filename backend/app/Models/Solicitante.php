<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Solicitante extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'solicitantes';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'nivel_usuario_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
