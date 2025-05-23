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
            $table->json('sasaran')->change();
            $table->json('jenis_sasaran')->change();
        });
    }

    public function down()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            $table->longText('sasaran')->change();
            $table->longText('jenis_sasaran')->change();
        });
    }
};
