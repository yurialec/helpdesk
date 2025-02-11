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
            ['id' => 1, 'label' => 'Home', 'icon' => 'bi bi-house', 'url' => '/admin/home', 'active' => 1, 'son' => null, 'order' => 1, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-11 11:22:46'],
            ['id' => 2, 'label' => 'Administrativo', 'icon' => 'bi bi-speedometer', 'url' => '#', 'active' => 1, 'son' => null, 'order' => 2, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-11 11:22:46'],
            ['id' => 3, 'label' => 'Usuários', 'icon' => 'bi bi-people', 'url' => '/admin/users', 'active' => 1, 'son' => 2, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:11:29'],
            ['id' => 4, 'label' => 'Perfis', 'icon' => 'bi bi-person-badge', 'url' => '/admin/roles', 'active' => 1, 'son' => 2, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:11:29'],
            ['id' => 5, 'label' => 'Permissões', 'icon' => 'bi bi-lock', 'url' => '/admin/permissions', 'active' => 1, 'son' => 2, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:11:29'],
            ['id' => 6, 'label' => 'Menus', 'icon' => 'bi bi-compass', 'url' => '/admin/menu', 'active' => 1, 'son' => 2, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:11:29'],
            ['id' => 10, 'label' => 'Sair', 'icon' => 'bi bi-box-arrow-right', 'url' => '/admin/logout', 'active' => 1, 'son' => null, 'order' => 7, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-11 18:56:24'],
            ['id' => 11, 'label' => 'Chat', 'icon' => 'bi bi-chat', 'url' => '#', 'active' => 1, 'son' => null, 'order' => 5, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-11 18:56:31'],
            ['id' => 12, 'label' => 'Chats', 'icon' => 'bi bi-chat-left-dots', 'url' => '/admin/chat/', 'active' => 1, 'son' => 11, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:11:29'],
            ['id' => 13, 'label' => 'Atendentes', 'icon' => 'bi bi-person-lines-fill', 'url' => '/admin/chat/attendants/', 'active' => 1, 'son' => 11, 'order' => null, 'created_at' => '2025-02-03 11:11:29', 'updated_at' => '2025-02-03 11:14:03'],
            ['id' => 14, 'label' => 'Clientes', 'icon' => 'bi bi-person-vcard', 'url' => '/admin/chat/clients/', 'active' => 1, 'son' => 11, 'order' => null, 'created_at' => '2025-02-03 13:59:22', 'updated_at' => '2025-02-03 13:59:22'],
            ['id' => 17, 'label' => 'Gestão de Chamados', 'icon' => 'bi bi-ticket', 'url' => '#', 'active' => 1, 'son' => null, 'order' => 6, 'created_at' => '2025-02-11 11:20:39', 'updated_at' => '2025-02-11 18:56:27'],
            ['id' => 19, 'label' => 'Site', 'icon' => 'bi bi-filetype-html', 'url' => '#', 'active' => 1, 'son' => null, 'order' => 3, 'created_at' => '2025-02-11 18:49:21', 'updated_at' => '2025-02-11 18:49:36'],
            ['id' => 20, 'label' => 'Logotipo', 'icon' => 'bi bi-flag', 'url' => '/admin/site/logo', 'active' => 1, 'son' => 19, 'order' => null, 'created_at' => '2025-02-11 18:51:24', 'updated_at' => '2025-02-11 18:51:24'],
            ['id' => 21, 'label' => 'Sobre', 'icon' => 'bi bi-card-text', 'url' => '/admin/site/site-about', 'active' => 1, 'son' => 19, 'order' => null, 'created_at' => '2025-02-11 18:51:24', 'updated_at' => '2025-02-11 18:51:24'],
            ['id' => 22, 'label' => 'Contato', 'icon' => 'bi bi-geo-alt', 'url' => '/admin/site/contact', 'active' => 1, 'son' => 19, 'order' => null, 'created_at' => '2025-02-11 18:51:24', 'updated_at' => '2025-02-11 18:51:24'],
            ['id' => 23, 'label' => 'Configurações Gerais', 'icon' => 'bi bi-gear', 'url' => '#', 'active' => 1, 'son' => null, 'order' => 4, 'created_at' => '2025-02-11 18:56:13', 'updated_at' => '2025-02-11 18:56:31'],
            ['id' => 24, 'label' => 'Empresas', 'icon' => 'bi bi-buildings', 'url' => '/admin/general-configs/companies', 'active' => 1, 'son' => 23, 'order' => null, 'created_at' => '2025-02-11 18:57:14', 'updated_at' => '2025-02-11 19:52:40'],
        ]);
    }
}
