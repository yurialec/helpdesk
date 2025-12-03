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
        return $this->belongsTo(TicketStatus::class);
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
        return $this->hasMany(TicketLog::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function system()
    {
        return $this->belongsTo(Systems::class, 'system_id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function scopeLevel1($query)
    {
        return $query;
    }

    /**
     * Nível 2 — Gerente de Service Desk
     * Vê somente incidentes e solicitações
     */
    public function scopeLevel2($query)
    {
        return $query->whereIn('type', ['incident', 'service_request']);
    }

    /**
     * Nível 3 — Especialista L3
     * Vê incidentes e problemas atribuídos ao próprio agente ou sem agente
     */
    public function scopeLevel3($query, $userId)
    {
        return $query->whereIn('type', ['incident', 'problem'])
            ->where(function ($q) use ($userId) {
                $q->where('agent_id', $userId)
                    ->orWhereNull('agent_id');
            });
    }

    /**
     * Nível 4 — Analista de Problemas
     * Vê apenas tickets do tipo problem
     */
    public function scopeLevel4($query)
    {
        return $query->where('type', 'problem');
    }

    /**
     * Nível 5 — Suporte N2
     * Must belong to same group OR unassigned
     */
    public function scopeLevel5($query, $groupId, $userId)
    {
        return $query->whereIn('type', ['incident', 'service_request'])
            ->where('group_id', $groupId)
            ->where(function ($q) use ($userId) {
                $q->where('agent_id', $userId)
                    ->orWhereNull('agent_id');
            });
    }

    /**
     * Nível 6 — Agente de Service Desk (N1)
     */
    public function scopeLevel6($query, $userId)
    {
        return $query->whereIn('type', ['incident', 'service_request'])
            ->where(function ($q) use ($userId) {
                $q->where('agent_id', $userId)
                    ->orWhereNull('agent_id');
            });
    }

    public function scopeByRole($query, $user)
    {
        switch ($user->role_id) {

            case 1:
                return $query->level1();

            case 2:
                return $query->level2();

            case 3:
                return $query->level3($user->id);

            case 4:
                return $query->level4();

            case 5:
                return $query->level5($user->group_id, $user->id);

            case 6:
                return $query->level6($user->id);
        }

        return $query;
    }
}
