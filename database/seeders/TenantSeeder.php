<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            'name' => 'getconnti',
            'domain' => 'getconnti',
            'database' => 'helpdesk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
