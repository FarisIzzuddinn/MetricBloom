<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::create('institution_add_kpi', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade'); // Foreign key to institutions
    //         $table->foreignId('kpi_id')->constrained('add_kpis')->onDelete('cascade'); // Change to kpi_id
    //         $table->timestamps(); // Created at and updated at timestamps
    //     });
    // }

    // public function down()
    // {
    //     Schema::dropIfExists('institution_add_kpi');
    // }
};
