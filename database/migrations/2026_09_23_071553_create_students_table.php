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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('parent_id')
                ->constrained('parents')
                ->cascadeOnDelete();
            $table->foreignId('institute_id')
                ->constrained('institutes')
                ->cascadeOnDelete();
            $table->string('student_code', 50);
            $table->string('name', 100);
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['institute_id', 'student_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
