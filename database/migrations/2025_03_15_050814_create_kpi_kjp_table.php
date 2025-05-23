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
        Schema::create('kpi_kjp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('add_kpi_id');
            $table->string('kjp_name'); // Storing the name
            $table->timestamps();
    
            // Foreign key reference
            $table->foreign('add_kpi_id')->references('id')->on('add_kpis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_kjp');
    }
};
