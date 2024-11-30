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
        Schema::create('user_entities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('state_id')->nullable(); // Foreign key to states table
            $table->unsignedBigInteger('institution_id')->nullable(); // Foreign key to institutions table
            $table->unsignedBigInteger('sector_id')->nullable(); // Foreign key to sectors table
            $table->unsignedBigInteger('bahagian_id')->nullable(); // Foreign key to bahagians table
            $table->timestamps();

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('set null');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('set null');
            $table->foreign('bahagian_id')->references('id')->on('bahagian')->onDelete('set null');

            // Add a unique constraint to prevent duplicate user-entity relationships
            $table->unique(['user_id', 'state_id', 'institution_id', 'sector_id', 'bahagian_id'], 'unique_user_entity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_entities');
    }
};
