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
        Schema::create('admin_dashboards', function (Blueprint $table) {
            $table->id();
            $table->integer('sortby');
            $table->string('negeri');
            $table->string('pemilik');
            $table->string('kpi');
            $table->string('penyataan_kpi');
            $table->integer('sasaran');
            $table->string('jenis_sasaran');
            $table->integer('pencapaian');
            $table->float('peratus_pencapaian');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_dashboards');
    }
};
