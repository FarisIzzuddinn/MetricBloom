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
        Schema::create('kpi_institutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('add_kpi_id'); // Foreign key to the KPI table
            $table->unsignedBigInteger('institution_id'); // Foreign key to the Institutions table
            $table->timestamps();

            // Foreign keys
            $table->foreign('add_kpi_id')->references('id')->on('add_kpis')->onDelete('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');

            // Prevent duplicate entries
            $table->unique(['add_kpi_id', 'institution_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_institutions');
    }
};
