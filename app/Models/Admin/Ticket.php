<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol',
        'company_id',
        'system_id',
        'requester_id',
        'agent_id',
        'group_id',
        'status_id',
        'priority_id',
        'sla_id',
        'category_id',
        'type',
        'impact',
        'urgency',
        'closure_code',
        'subject',
        'description',
        'due_date',
        'resolved_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function sla()
    {
        return $this->belongsTo(Sla::class, 'sla_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function group()
    {
        return $this->belongsTo(SupportGroup::class, 'group_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class, 'ticket_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function system()
    {
        return $this->belongsTo(Systems::class, 'system_id');
    }
}
