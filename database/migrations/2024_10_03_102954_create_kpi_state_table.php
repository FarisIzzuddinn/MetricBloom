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
        Schema::create('kpi_states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('add_kpi_id'); // Foreign key to the KPI table
            $table->unsignedBigInteger('state_id'); // Foreign key to the States table
            $table->timestamps();

            // Foreign keys
            $table->foreign('add_kpi_id')->references('id')->on('add_kpis')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

            // Prevent duplicate entries
            $table->unique(['add_kpi_id', 'state_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_states');
    }
};
