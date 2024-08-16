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
        Schema::create('_keselamatan_inteligen', function (Blueprint $table) {
            $table->string('Kod')->primary();
            $table->string('Tajuk_KPI');
            $table->string('Sasaran_KPI');
            $table->timestamps();
        });

        // Schema::create('sektor_keselamatan_koreksional', function (Blueprint $table) {
        //     $table->string('Kod');
        //     $table->foreign('Kod', 'fk_kod_keselamatan_inteligen')->references('Kod')->on('_keselamatan_inteligen')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('sektor_keselamatan_koreksional');
        Schema::dropIfExists('_keselamatan_inteligen');
    }
};

