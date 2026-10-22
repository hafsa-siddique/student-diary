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
        Schema::create('diary_parent_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diary_entry_id')->constrained('diary_entries')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('users')->cascadeOnDelete(); 
            $table->boolean('is_completed')->default(false);
            $table->text('remarks')->nullable();
            $table->boolean('teacher_acknowledged')->default(false);
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();
            $table->unique(['diary_entry_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_parent_feedbacks');
    }
};
