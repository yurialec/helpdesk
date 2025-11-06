<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'response_time',
        'resolution_time',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'sla_id');
    }
}
