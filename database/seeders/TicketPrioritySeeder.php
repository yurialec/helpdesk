<?php

namespace Database\Seeders;

use App\Models\Admin\TicketPriority;
use Illuminate\Database\Seeder;

class TicketPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1, 'color_code' => '#27ae60'],
            ['name' => 'Medium', 'level' => 2, 'color_code' => '#f1c40f'],
            ['name' => 'High', 'level' => 3, 'color_code' => '#e67e22'],
            ['name' => 'Critical', 'level' => 4, 'color_code' => '#e74c3c'],
        ];

        foreach ($priorities as $priority) {
            TicketPriority::updateOrCreate(
                ['name' => $priority['name']],
                $priority
            );
        }
    }
}
