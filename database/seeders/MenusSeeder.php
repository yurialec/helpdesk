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
        DB::table('menus')->insert([
            'label' => 'Administrativo',
            'icon' => 'bi bi-house-gear',
            'url' => '#',
            'active' => 1,
            'son' => null,
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $adminMenuId = DB::getPdo()->lastInsertId();

        DB::table('menus')->insert([
            [
                'label' => 'Usuários',
                'icon' => 'bi bi-people',
                'url' => '/admin/users',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Perfis',
                'icon' => 'bi bi-person-badge',
                'url' => '/admin/roles',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Permissões',
                'icon' => 'bi bi-lock',
                'url' => '/admin/permissions',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Menus',
                'icon' => 'bi bi-compass',
                'url' => '/admin/menu',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('menus')->insert([
            'label' => 'Site',
            'icon' => 'bi bi-newspaper',
            'url' => '/admin/site/',
            'active' => 1,
            'son' => null,
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $siteMenuId = DB::getPdo()->lastInsertId();
    }
}
