<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in-progress', 'completed'])->default('pending');
            $table->foreignId('assigned_to')->constrained('users');
            $table->foreignId('assigned_by')->constrained('users');
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};
