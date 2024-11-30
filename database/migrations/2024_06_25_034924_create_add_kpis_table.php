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
        // Check if the table does not exist before creating it
        if (!Schema::hasTable('add_kpis')) {
            Schema::create('add_kpis', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('teras_id'); // Foreign key to Teras
                $table->unsignedBigInteger('sectors_id')->nullable(); // Foreign key to Sectors
                $table->string('pernyataan_kpi'); // KPI Statement
                $table->string('jenis_sasaran'); // Target Type
                $table->decimal('sasaran', 10, 2); // Target Value
                // $table->decimal('pencapaian', 10, 2)->default(0); // Achievement Value
                // $table->decimal('peratus_pencapaian', 5, 2)->nullable(); // Achievement Percentaget
                $table->timestamps();
                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_kpis');
    }
};
