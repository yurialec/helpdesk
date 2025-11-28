<?php

namespace App\Utils;

use App\Models\Admin\Roles;
use App\Models\Admin\Ticket;
use App\Models\User;
use DB;

class Agents
{
    public static function next()
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