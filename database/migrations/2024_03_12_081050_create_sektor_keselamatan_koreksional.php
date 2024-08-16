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
        Schema::create('sektor_keselamatan_koreksional', function (Blueprint $table) {
            $table->string('Kod');
            $table->string('Tajuk_KPI');
            $table->string('Sasaran_KPI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sektor_keselamatan_koreksional');
    }
};
