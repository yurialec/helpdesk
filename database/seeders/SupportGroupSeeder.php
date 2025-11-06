<?php

namespace Database\Seeders;

use App\Models\Admin\SupportGroup;
use Illuminate\Database\Seeder;

class SupportGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Suporte Nível 1',
                'description' => 'Atendimento inicial e triagem de chamados',
            ],
            [
                'name' => 'Suporte Nível 2',
                'description' => 'Resolução de incidentes complexos e análise técnica',
            ],
            [
                'name' => 'Infraestrutura',
                'description' => 'Gerenciamento de redes, servidores e hardware',
            ],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Correção e melhoria de sistemas internos e externos',
            ],
        ];

        foreach ($groups as $group) {
            SupportGroup::updateOrCreate(
                ['name' => $group['name']],
                $group
            );
        }
    }
}
