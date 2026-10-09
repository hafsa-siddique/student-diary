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
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_assignment_id')
                ->constrained('teacher_assignments')
                ->cascadeOnDelete();
            $table->date('diary_date');
            $table->text('classwork')->nullable();
            $table->text('homework')->nullable();
            $table->text('instructions')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status', 20)
                ->default('draft')
                ->comment('draft, published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index([
                'teacher_assignment_id',
                'diary_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
    }
};
