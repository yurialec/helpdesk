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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade'); // Relaciona com a tabela `conversations`
            $table->unsignedBigInteger('sender_id'); // ID do remetente (cliente ou atendente)
            $table->string('sender_type'); // Tipo do remetente (Client ou User)
            $table->text('message_content'); // Conteúdo da mensagem
            $table->timestamps();

            // Índice para consulta rápida de sender_id e sender_type
            $table->index(['sender_id', 'sender_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
