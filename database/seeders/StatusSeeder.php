<?php

namespace Database\Seeders;

use App\Models\Admin\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Open', 'color_code' => '#f39c12'],
            ['name' => 'In Progress', 'color_code' => '#3498db'],
            ['name' => 'Awaiting Client', 'color_code' => '#95a5a6'],
            ['name' => 'Resolved', 'color_code' => '#2ecc71'],
            ['name' => 'Closed', 'color_code' => '#7f8c8d'],
        ];

        foreach ($statuses as $status) {
            TicketStatus::firstOrCreate(
                ['name' => $status['name']],
                ['color_code' => $status['color_code']]
            );
        }
    }
}
