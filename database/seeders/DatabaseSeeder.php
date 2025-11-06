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
        $this->call(OrderMenuSeeder::class);
        $this->call(SystemCategorySeeder::class);
        $this->call(TicketStatusSeeder::class);
        $this->call(TicketPrioritySeeder::class);
        $this->call(SlaSeeder::class);
        $this->call(TicketCategorySeeder::class);
        $this->call(SupportGroupSeeder::class);
        $this->call(TicketSeeder::class);
    }
}
