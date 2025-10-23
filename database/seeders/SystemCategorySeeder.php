<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Financeiro', 'description' => 'Sistemas voltados para controle financeiro e emissão de notas fiscais.'],
            ['name' => 'Saúde', 'description' => 'Sistemas para clínicas, hospitais e consultórios.'],
            ['name' => 'Educação', 'description' => 'Sistemas de gestão escolar e ensino à distância.'],
            ['name' => 'Comercial', 'description' => 'Sistemas de controle de vendas e estoque.'],
            ['name' => 'Serviços', 'description' => 'Soluções para empresas prestadoras de serviços.'],
            ['name' => 'Condomínio', 'description' => 'Gestão de condomínios, portarias e manutenção predial.'],
            ['name' => 'Governo', 'description' => 'Sistemas voltados para prefeituras, secretarias e órgãos públicos.'],
        ];

        foreach ($categories as $category) {
            DB::table('system_categories')->updateOrInsert(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
