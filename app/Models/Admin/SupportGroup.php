<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'group_id');
    }

    public function agents()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
                    ->withTimestamps();
    }
}
