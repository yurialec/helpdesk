<?php

namespace Database\Seeders;

use App\Enums\ChatStatusEnum;
use App\Models\Chat\ChatStatus;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ChatStatusEnum::cases() as $status) {
            if (!ChatStatus::where("name", $status->value)->first()) {
                ChatStatus::create([
                    'name' => $status->value,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }
}
