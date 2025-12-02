<?php
namespace App\Utils;

use App\Models\Admin\Roles;
use App\Models\Admin\Ticket;
use App\Models\User;
use Carbon\Carbon;
use DB;

class TicketHelper
{
    /**
     * Gera o numero de protocolo
     * @return string
     */
    public static function generateProtocol(): string
    {
        $dt = Carbon::now()->format('my');

        $currentMonth = Carbon::now();
        $tickets = Ticket::whereMonth('created_at', $currentMonth->month)->count() + 1;

        if ((strlen($tickets) === 1)) {
            $value = '0000' . $tickets;
        } else {
            $trimmedString = substr('0000', 0, -strlen($tickets));
            $value = $trimmedString . $tickets;
        }


        return 'P' . $value . $dt;
    }

    /**
     * proximo agente disponivel
     * @return int|null
     */
    public static function nextAgent(): int|null
    {
        $agents = User::where('role_id', Roles::AGENT_LEVEL_1_ID)->get();
        if ($agents->isEmpty()) {
            return null;
        }

        $ticketsCount = Ticket::select('agent_id', DB::raw('COUNT(*) as total'))
            ->whereIn('agent_id', $agents->pluck('id'))
            ->groupBy('agent_id')
            ->pluck('total', 'agent_id');

        $agents = $agents->map(function ($agent) use ($ticketsCount) {
            $agent->tickets_total = $ticketsCount[$agent->id] ?? 0;
            return $agent;
        });

        $nextAgent = $agents->sortBy('tickets_total')->first();

        return $nextAgent->id;
    }
}