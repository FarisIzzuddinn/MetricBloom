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
        Schema::table('kpi_kjp', function (Blueprint $table) {
            $table->dropColumn('kjp_name');
            $table->unsignedBigInteger('kjp_id')->after('add_kpi_id');
            $table->foreign('kjp_id')->references('id')->on('kjps')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpi_kjp', function (Blueprint $table) {
            //
        });
    }
};
