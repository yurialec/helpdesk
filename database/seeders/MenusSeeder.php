<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menu principal
        DB::table('menus')->insert([
            'label' => 'Administrativo',
            'icon' => 'fa-solid fa-cogs',
            'url' => '#',
            'active' => 1,
            'son' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Recupera o ID do menu principal
        $adminMenuId = DB::getPdo()->lastInsertId();

        // Submenus
        DB::table('menus')->insert([
            [
                'label' => 'Usuários',
                'icon' => 'fa-solid fa-users',
                'url' => '/admin/users',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Perfis',
                'icon' => 'fa-solid fa-id-badge',
                'url' => '/admin/roles',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Permissões',
                'icon' => 'fa-solid fa-lock',
                'url' => '/admin/permissions',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
