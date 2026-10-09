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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')
                ->nullable()
                ->constrained('institutes')
                ->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('password');
            $table->string('role', 20)->comment('super_admin,admin, teacher, parent, student');
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->unique(['institute_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
