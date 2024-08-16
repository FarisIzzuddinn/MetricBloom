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
        Schema::create('banduan_tahanan_radikal', function (Blueprint $table) {
            $table->string('Kod')->primary();
            $table->string('Tajuk_KPI'); 
            $table->string('Sasaran_KPI'); 
            $table->timestamps();
        });

        // Schema::create('sektor_keselamatan_koreksional', function (Blueprint $table) {
        //     $table->string('Kod');
        //     $table->foreign('Kod', 'fk_kod_banduan_tahanan_radikal')->references('Kod')->on('banduan_tahanan_radikal')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('sektor_keselamatan_koreksional');
        Schema::dropIfExists('banduan_tahanan_radikal');
    }
};
