<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('protocol');
            $table->bigInteger('client_id')->unsigned()->index()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('chat_status_id')->unsigned()->index()->nullable();
            $table->foreign('chat_status_id')->references('id')->on('chat_status')->onDelete('cascade');
            $table->dateTime('ended_at')->nullable();
            $table->integer('finished_id')->nullable();
            $table->boolean('is_client_finished')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
