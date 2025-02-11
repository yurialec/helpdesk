<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'address',
        'email',
        'phone',
        'responsible_manager',
    ];
}