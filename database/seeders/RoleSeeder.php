<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Gerente de Serviço',
                'level' => 1,
                'description' => 'Responsável pela estratégia, desempenho e melhoria contínua de um serviço específico. Vê toda a hierarquia.'
            ],
            [
                'name' => 'Gerente de Service Desk',
                'level' => 2,
                'description' => 'Coordena as operações diárias do Service Desk, a equipe e o fluxo de incidentes.'
            ],
            [
                'name' => 'Especialista de Sistema (L3)',
                'level' => 3,
                'description' => 'Especialista de TI para resolução de problemas complexos e alteração de código (Nível 3 de suporte).'
            ],
            [
                'name' => 'Analista de Problemas',
                'level' => 4,
                'description' => 'Atua no Backoffice, responsável pela análise de causa raiz de incidentes e prevenção de reincidências.'
            ],
            [
                'name' => 'Técnico de Suporte Nível 2',
                'level' => 5,
                'description' => 'Responsável por resolver incidentes escalados que exigem conhecimento técnico aprofundado.'
            ],
            [
                'name' => 'Agente de Service Desk (Nível 1)',
                'level' => 6,
                'description' => 'Primeiro ponto de contato (SPOC), responsável por registrar, classificar e resolver incidentes simples.'
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'level' => $role['level'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }
    }
}
