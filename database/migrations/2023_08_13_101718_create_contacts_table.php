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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->char('name', 100);
            $table->char('first_name', 50);
            $table->char('last_name', 50);
            $table->boolean('is_volunteer');
            $table->string('primary_email', 40);
            $table->string('phone', 12)->nullable();
            $table->boolean('is_textable')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
