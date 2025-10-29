<?php

namespace Database\Seeders;

use App\Models\Admin\TicketPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1, 'color_code' => '#27ae60'],
            ['name' => 'Medium', 'level' => 2, 'color_code' => '#f1c40f'],
            ['name' => 'High', 'level' => 3, 'color_code' => '#e67e22'],
            ['name' => 'Urgent', 'level' => 4, 'color_code' => '#c0392b'],
        ];

        foreach ($priorities as $priority) {
            TicketPriority::firstOrCreate(
                ['name' => $priority['name']],
                [
                    'level' => $priority['level'],
                    'color_code' => $priority['color_code'],
                ]
            );
        }
    }
}
