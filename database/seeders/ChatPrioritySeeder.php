<?php

namespace Database\Seeders;

use App\Enums\ChatPriorityEnum;
use App\Models\Chat\ChatPriority;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChatPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ChatPriorityEnum::cases() as $priority) {
            if (!ChatPriority::where("name", $priority->value)->first()) {
                ChatPriority::create([
                    'name' => $priority->value,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }
}
