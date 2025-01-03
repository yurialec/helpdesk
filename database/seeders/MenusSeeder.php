<?php

namespace Database\Seeders;

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
            'label' => 'Home',
            'icon' => 'bi bi-house',
            'url' => '/admin/home',
            'active' => 1,
            'son' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('menus')->insert([
            'label' => 'Administrativo',
            'icon' => 'bi bi-speedometer',
            'url' => '#',
            'active' => 1,
            'son' => null,
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
            ],
            [
                'label' => 'Logotipo',
                'icon' => 'bi bi-flag',
                'url' => '/admin/site/logo',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Sobre',
                'icon' => 'bi bi-card-text',
                'url' => '/admin/site/site-about',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Contato',
                'icon' => 'bi bi-geo-alt',
                'url' => '/admin/site/contact',
                'active' => 1,
                'son' => $adminMenuId,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('menus')->insert([
            'label' => 'Sair',
            'icon' => 'bi bi-box-arrow-right',
            'url' => '/admin/logout',
            'active' => 1,
            'son' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
