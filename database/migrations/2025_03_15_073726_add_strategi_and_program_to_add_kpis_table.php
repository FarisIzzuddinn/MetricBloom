<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            $table->string('strategi')->nullable();  // Add strategi column
            $table->string('program')->nullable();  // Add program column
            $table->string('kategori_report')->nullable();  // Add program column
            $table->string('aktiviti')->nullable();  // Add program column
            $table->string('outcome')->nullable();  // Add program column
            $table->string('keterangan')->nullable();  // Add program column
            $table->string('justifikasi')->nullable();  // Add program column
            $table->string('trend_pencapaian')->nullable();  // Add program column
            $table->string('kaveat')->nullable();  // Add program column
            $table->string('formula')->nullable();  // Add program column


            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            $table->dropColumn('strategi');  // Remove strategi column
            $table->dropColumn('program');   // Remove program column
            $table->dropColumn('kategori_report');   // Remove program column
            $table->dropColumn('aktiviti');   // Remove program column
            $table->dropColumn('outcome');   // Remove program column
            $table->dropColumn('keterangan');   // Remove program column
            $table->dropColumn('justifikasi');   // Remove program column
            $table->dropColumn('trend_pencapaian');   // Remove program column
            $table->dropColumn('kaveat');   // Remove program column
            $table->dropColumn('formula');   // Remove program column

        });
    }
};
