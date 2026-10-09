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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('institute_id')
                ->constrained('institutes')
                ->cascadeOnDelete();
            $table->string('employee_code', 50);
            $table->string('phone', 30)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['institute_id', 'employee_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
