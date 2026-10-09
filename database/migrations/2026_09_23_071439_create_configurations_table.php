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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')
                    ->constrained('institutes')
                    ->unique()
                    ->cascadeOnDelete();
            $table->string('main_logo',255)->nullable();
            $table->string('small_logo',255)->nullable();
            $table->string('login_logo',255)->nullable();
            $table->string('favicon',255)->nullable();
            $table->string('primary_color',20)->nullable();
            $table->string('secondary_color',20)->nullable();
            $table->string('contact_email',150)->nullable();
            $table->string('contact_phone',30)->nullable();
            $table->string('address',255)->nullable();
            $table->string('website',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
