<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'phone',
        'address',
        'active',
    ];

    public function systems()
    {
        return $this->hasMany(Systems::class, 'company_id');
    }
}