<?php

namespace Database\Seeders;

use App\Models\Admin\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'color_code' => '#3498db', 'description' => 'Ticket recém-criado'],
            ['name' => 'In Progress', 'color_code' => '#f1c40f', 'description' => 'Em atendimento'],
            ['name' => 'Pending Customer', 'color_code' => '#9b59b6', 'description' => 'Aguardando resposta do cliente'],
            ['name' => 'Pending Vendor', 'color_code' => '#8e44ad', 'description' => 'Aguardando retorno do fornecedor'],
            ['name' => 'Resolved', 'color_code' => '#2ecc71', 'description' => 'Solução aplicada, aguardando validação'],
            ['name' => 'Closed', 'color_code' => '#16a085', 'description' => 'Ticket encerrado com sucesso'],
            ['name' => 'Cancelled', 'color_code' => '#e74c3c', 'description' => 'Ticket cancelado antes da resolução'],
        ];

        foreach ($statuses as $status) {
            TicketStatus::updateOrCreate(
                ['name' => $status['name']],
                $status
            );
        }
    }
}
