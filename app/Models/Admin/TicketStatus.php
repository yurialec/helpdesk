<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;
    protected $table = 'ticket_statuses';

    protected $fillable = [
        'name',
        'color_code',
    ];
}
