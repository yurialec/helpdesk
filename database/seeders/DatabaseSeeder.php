<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(ChatStatusSeeder::class);
        $this->call(ChatPrioritySeeder::class);
        $this->call(OrderMenuSeeder::class);
    }
}
