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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('system_id')->nullable()->constrained('systems')->onDelete('set null');
            $table->foreignId('requester_id')->nullable()->comment('The user who opened the ticket')->constrained('users')->onDelete('restrict');
            $table->foreignId('agent_id')->nullable()->comment('The user/agent assigned to the ticket')->constrained('users')->onDelete('set null');
            $table->foreignId('status_id')->constrained('ticket_statuses')->onDelete('restrict');
            $table->foreignId('priority_id')->constrained('ticket_priorities')->onDelete('restrict');
            $table->string('subject');
            $table->text('description');
            $table->timestamp('due_date')->nullable()->comment('SLA due date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
