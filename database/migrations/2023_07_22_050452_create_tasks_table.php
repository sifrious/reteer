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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('sheets_id')->unique();
            $table->string('sheets_row');
            $table->timestamp('sheets_created_at')->nullable();
            $table->string('name')->nullable();
            $table->string('author')->nullable();
            $table->string('start_date')->nullable();
            $table->string('start_time')->nullable();
            $table->integer('public');
            $table->string('client_address')->nullable();
            $table->string('task_description');
            $table->string('destination')->nullable();
            $table->string('volunteer')->nullable();
            $table->string('status')->nullable();
            $table->string('contact_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
