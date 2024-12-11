<?php

use App\Enums\ChatPriorityEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_priority', function (Blueprint $table) {
            $table->id();
            $table->enum('name', array_column(ChatPriorityEnum::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_priority');
    }
};
