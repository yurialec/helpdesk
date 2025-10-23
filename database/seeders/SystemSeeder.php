<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id') ?? 1;

        $financeiroId = DB::table('system_categories')->where('name', 'Financeiro')->value('id');
        $servicosId = DB::table('system_categories')->where('name', 'Serviços')->value('id');
        $condominioId = DB::table('system_categories')->where('name', 'Condomínio')->value('id');
        $governoId = DB::table('system_categories')->where('name', 'Governo')->value('id');

        $systems = [
            [
                'name' => 'Emissão de notas fiscais',
                'description' => 'Sistema de emissão de NF-e, NFC-e e NFS-e com controle financeiro integrado.',
                'category_id' => $financeiroId,
                'company_id' => $companyId,
            ],
            [
                'name' => 'Manutenção Predial',
                'description' => 'Sistema de gestão de ordens de serviço e manutenção para condomínios e prédios comerciais.',
                'category_id' => $condominioId,
                'company_id' => $companyId,
            ],
            [
                'name' => 'Portal Cidadão',
                'description' => 'Sistema de atendimento digital para prefeituras e órgãos públicos.',
                'category_id' => $governoId,
                'company_id' => $companyId,
            ],
        ];

        foreach ($systems as $system) {
            DB::table('systems')->updateOrInsert(
                ['name' => $system['name']],
                [
                    'description' => $system['description'],
                    'category_id' => $system['category_id'],
                    'company_id' => $system['company_id'],
                    'active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
