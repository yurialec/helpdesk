<?php

namespace Database\Seeders;

use App\Models\Admin\Roles;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456a!');

        $usersToSeed = [
            [
                'name' => 'Desenvolvedor',
                'email' => 'dev@system.com',
                'password' => $password,
                'role_name' => 'Gerente de Serviço',
            ],
            [
                'name' => 'Administrador Master',
                'email' => 'admin@system.com',
                'password' => $password,
                'role_name' => 'Gerente de Service Desk',
            ],
            [
                'name' => 'Gestor de Equipe',
                'email' => 'gestor@system.com',
                'password' => $password,
                'role_name' => 'Especialista de Sistema (L3)',
            ],
            [
                'name' => 'Suporte Backoffice',
                'email' => 'backoffice@system.com',
                'password' => $password,
                'role_name' => 'Analista de Problemas',
            ],
            [
                'name' => 'Tecnico Nivel 2',
                'email' => 'tech2@system.com',
                'password' => $password,
                'role_name' => 'Técnico de Suporte Nível 2',
            ],
            [
                'name' => 'Tecnico Nivel 1',
                'email' => 'tech1@system.com',
                'password' => $password,
                'role_name' => 'Agente de Service Desk (Nível 1)',
            ],
        ];

        foreach ($usersToSeed as $userData) {
            $roleId = Roles::where('name', $userData['role_name'])->firstOrFail()->id;

            unset($userData['role_name']);

            DB::table('users')->updateOrInsert(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'role_id' => $roleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('Users seeded successfully, including one for each role.');
    }
}
