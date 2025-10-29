<?php

namespace Database\Seeders;

use App\Models\Admin\Companies;
use App\Models\Admin\Systems;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketPriority;
use App\Models\Admin\TicketStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. Encontrar IDs válidos para as Foreign Keys ---

        // Tenta encontrar um ID existente, ou falha se não houver dados (ideal para ambientes de estudo)
        $company = Companies::inRandomOrder()->firstOrFail();
        $product = Systems::inRandomOrder()->where('company_id', $company->id)->first(); // Tenta um produto da mesma empresa

        $requester = User::inRandomOrder()->firstOrFail(); // Usuário solicitante
        $agent = User::inRandomOrder()->firstOrFail(); // Agente

        $status = TicketStatus::where('name', 'Open')->firstOrFail(); // Geralmente iniciamos com 'Open'
        $priority = TicketPriority::where('name', 'Medium')->firstOrFail(); // Exemplo de prioridade

        // --- 2. Gerar dados de exemplo ---

        $ticketData = [
            'company_id' => $company->id,
            'system_id' => $product ? $product->id : null, // Pode ser null se não encontrar um produto específico
            'requester_id' => $requester->id,
            'agent_id' => $agent->id,
            'status_id' => $status->id,
            'priority_id' => $priority->id,
            'subject' => 'System is extremely slow after latest update',
            'description' => 'Since the deployment on Tuesday, the system performance has degraded significantly, especially during peak hours (10 AM - 2 PM). Please investigate database query times.',
            'due_date' => now()->addDays(3), // Data de vencimento (SLA)
        ];

        // --- 3. Criar o Ticket ---
        Ticket::create($ticketData);

        $this->command->info('One sample ticket created successfully!');
    }
}
