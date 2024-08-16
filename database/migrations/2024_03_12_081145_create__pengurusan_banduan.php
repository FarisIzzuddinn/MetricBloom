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
        Schema::create('_pengurusan_banduan', function (Blueprint $table) {
            $table->string('Kod')->primary();
            $table->string('Tajuk_KPI'); 
            $table->string('Sasaran_KPI'); 
            $table->timestamps();
        });

        // Schema::create('sektor_keselamatan_koreksional', function (Blueprint $table) {
        //     $table->string('Kod');
        //     $table->foreign('Kod', 'fk_kod_pengurusan_banduan')->references('Kod')->on('_pengurusan_banduan')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('sektor_keselamatan_koreksional');
        Schema::dropIfExists('_pengurusan_banduan');
    }
};
