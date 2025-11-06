<?php

namespace Database\Seeders;

use App\Models\Admin\Sla;
use App\Models\Admin\SupportGroup;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketCategory;
use App\Models\Admin\TicketPriority;
use App\Models\Admin\TicketStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusNew = TicketStatus::where('name', 'New')->first();
        $statusProgress = TicketStatus::where('name', 'In Progress')->first();
        $statusResolved = TicketStatus::where('name', 'Resolved')->first();

        $priorityLow = TicketPriority::where('name', 'Low')->first();
        $priorityHigh = TicketPriority::where('name', 'High')->first();
        $priorityCritical = TicketPriority::where('name', 'Critical')->first();

        $slaPadrao = Sla::where('name', 'SLA Padrão')->first();
        $slaCritico = Sla::where('name', 'SLA Crítico')->first();

        $catHardware = TicketCategory::where('name', 'Computadores')->first();
        $catSoftware = TicketCategory::where('name', 'Sistemas Internos')->first();
        $catRede = TicketCategory::where('name', 'Servidores')->first();

        $groupN1 = SupportGroup::where('name', 'Suporte Nível 1')->first();
        $groupDev = SupportGroup::where('name', 'Desenvolvimento')->first();

        $requester = User::first();
        $agent = User::skip(1)->first();

        $tickets = [
            [
                'protocol' => strtoupper(Str::random(8)),
                'company_id' => 1,
                'system_id' => 1,
                'requester_id' => $requester?->id,
                'agent_id' => $agent?->id,
                'group_id' => $groupN1?->id,
                'status_id' => $statusNew?->id,
                'priority_id' => $priorityLow?->id,
                'sla_id' => $slaPadrao?->id,
                'category_id' => $catHardware?->id,
                'type' => 'incident',
                'impact' => 'low',
                'urgency' => 'medium',
                'subject' => 'Computador não liga',
                'description' => 'O computador do setor financeiro não está ligando desde ontem.',
                'due_date' => now()->addHours(4),
            ],
            [
                'protocol' => strtoupper(Str::random(8)),
                'company_id' => 1,
                'system_id' => 1,
                'requester_id' => $requester?->id,
                'agent_id' => $agent?->id,
                'group_id' => $groupDev?->id,
                'status_id' => $statusProgress?->id,
                'priority_id' => $priorityHigh?->id,
                'sla_id' => $slaCritico?->id,
                'category_id' => $catSoftware?->id,
                'type' => 'incident',
                'impact' => 'high',
                'urgency' => 'high',
                'subject' => 'Erro ao emitir NF-e',
                'description' => 'O módulo fiscal está retornando erro 500 ao tentar emitir notas.',
                'due_date' => now()->addHour(),
            ],
            [
                'protocol' => strtoupper(Str::random(8)),
                'company_id' => 1,
                'system_id' => 1,
                'requester_id' => $requester?->id,
                'agent_id' => $agent?->id,
                'group_id' => $groupN1?->id,
                'status_id' => $statusResolved?->id,
                'priority_id' => $priorityCritical?->id,
                'sla_id' => $slaCritico?->id,
                'category_id' => $catRede?->id,
                'type' => 'incident',
                'impact' => 'high',
                'urgency' => 'high',
                'subject' => 'Servidor indisponível',
                'description' => 'O servidor de aplicação ficou fora do ar por 30 minutos.',
                'resolved_at' => now(),
                'due_date' => now()->addMinutes(45),
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::updateOrCreate(
                ['protocol' => $ticket['protocol']],
                $ticket
            );
        }
    }
}
