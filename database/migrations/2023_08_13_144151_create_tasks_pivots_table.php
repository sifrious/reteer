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
        Schema::create('tasks_pivots', function (Blueprint $table) {
            $table->id('task_id')->constrained();
            $table->foreignId('event_id')->constrained()->nullable();
            $table->foreignId('contact_id')->constrained()->nullable();
            $table->boolean('many_contacts')->default(false);
            $table->unsignedBigInteger('client_address_id')
                ->nullable();
            $table->foreign('client_address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');
            $table->unsignedBigInteger('destination_id')
                ->nullable();
            $table->foreign('destination_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');
            $table->boolean('many_addresses')->default(false);
            $table->foreignId('volunteer_id')->constrained()->nullable();
            $table->boolean('many_volunteers')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_pivots');
    }
};
