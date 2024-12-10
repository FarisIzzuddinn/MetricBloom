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
        Schema::create('kpi_achievement', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('kpi_id'); // Foreign Key to KPIs
            $table->unsignedBigInteger('state_id'); // Foreign Key to States
            $table->unsignedBigInteger('institution_id'); // Foreign Key to Institutions
            $table->unsignedBigInteger('sector_id')->nullable(); // Foreign Key to Sectors
            $table->date('achievement_date'); // Date of Achievement
            $table->decimal('actual_value', 8, 2); // Actual Performance Value
            $table->decimal('target_value', 8, 2); // Target Value
            $table->string('status')->default('Pending'); // Status: Pending, Achieved, Overdue

            // Foreign Key Constraints
            $table->foreign('kpi_id')->references('id')->on('add_kpis')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('set null');

            $table->timestamps(); // Created At, Updated At
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpi_achievements');
    }
};
