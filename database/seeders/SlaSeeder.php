<?php

namespace Database\Seeders;

use App\Models\Admin\Sla;
use Illuminate\Database\Seeder;

class SlaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slas = [
            [
                'name' => 'SLA Padrão',
                'response_time' => 60,
                'resolution_time' => 240,
                'description' => 'SLA padrão para chamados normais'
            ],
            [
                'name' => 'SLA Crítico',
                'response_time' => 15,
                'resolution_time' => 60,
                'description' => 'SLA emergencial para falhas críticas'
            ],
            [
                'name' => 'SLA Baixa Prioridade',
                'response_time' => 180,
                'resolution_time' => 720,
                'description' => 'SLA estendido para solicitações simples'
            ],
        ];

        foreach ($slas as $sla) {
            Sla::updateOrCreate(
                ['name' => $sla['name']],
                $sla
            );
        }
    }
}
