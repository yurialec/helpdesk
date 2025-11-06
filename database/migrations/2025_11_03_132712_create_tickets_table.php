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
            $table->string('protocol', 20)->unique();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('system_id')->nullable()->constrained();
            $table->foreignId('requester_id')->nullable()->constrained('users');
            $table->foreignId('agent_id')->nullable()->constrained('users');
            $table->foreignId('group_id')->nullable()->constrained('support_groups');
            $table->foreignId('status_id')->constrained('ticket_statuses');
            $table->foreignId('priority_id')->constrained('ticket_priorities');
            $table->foreignId('sla_id')->nullable()->constrained('slas');
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories');

            $table->enum('type', ['incident', 'service_request', 'problem', 'change'])->default('incident');
            $table->enum('impact', ['low', 'medium', 'high'])->nullable();
            $table->enum('urgency', ['low', 'medium', 'high'])->nullable();
            $table->string('closure_code')->nullable();

            $table->string('subject');
            $table->text('description');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('resolved_at')->nullable();

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
