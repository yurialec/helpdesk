<?php

namespace Database\Seeders;

use App\Models\Admin\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $hardware = TicketCategory::updateOrCreate(['name' => 'Hardware']);
        $software = TicketCategory::updateOrCreate(['name' => 'Software']);
        $rede = TicketCategory::updateOrCreate(['name' => 'Rede']);

        $subcategories = [
            ['name' => 'Computadores', 'parent_id' => $hardware->id],
            ['name' => 'Impressoras', 'parent_id' => $hardware->id],
            ['name' => 'Sistemas Internos', 'parent_id' => $software->id],
            ['name' => 'Banco de Dados', 'parent_id' => $software->id],
            ['name' => 'Wi-Fi', 'parent_id' => $rede->id],
            ['name' => 'Servidores', 'parent_id' => $rede->id],
        ];

        foreach ($subcategories as $sub) {
            TicketCategory::updateOrCreate(
                ['name' => $sub['name']],
                $sub
            );
        }
    }
}
