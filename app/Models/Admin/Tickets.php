<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'protocol',
        'company_id',
        'system_id',
        'requester_id',
        'agent_id',
        'status_id',
        'priority_id',
        'subject',
        'description',
        'due_date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $basePrefix = 'P' . \Carbon\Carbon::now()->format('dmy');
            $count = Ticket::where('protocol', 'like', $basePrefix . '%')->count();
            $nextNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
            $ticket->protocol = $basePrefix . $nextNumber;
        });
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function system()
    {
        return $this->belongsTo(Systems::class, 'system_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}