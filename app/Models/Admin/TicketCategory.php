<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(TicketCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TicketCategory::class, 'parent_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }
}
