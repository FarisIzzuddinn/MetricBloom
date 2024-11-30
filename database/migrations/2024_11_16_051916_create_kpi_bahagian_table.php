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
        Schema::create('kpi_bahagian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('add_kpi_id'); // Foreign key to the KPI table
            $table->unsignedBigInteger('bahagian_id'); // Foreign key to the Bahagian table
            $table->float('pencapaian')->default(0);
            $table->float('peratus_pencapaian')->default(0);
            $table->string('status')->default('not achieved');
            $table->timestamps();

            // Foreign keys
            $table->foreign('add_kpi_id')->references('id')->on('add_kpis')->onDelete('cascade');
            $table->foreign('bahagian_id')->references('id')->on('bahagian')->onDelete('cascade');

            // Prevent duplicate entries
            $table->unique(['add_kpi_id', 'bahagian_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_bahagian');
    }
};
