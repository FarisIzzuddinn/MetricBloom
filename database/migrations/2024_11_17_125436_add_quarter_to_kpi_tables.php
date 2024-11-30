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
        // Add quarter column to kpi_bahagian table
        Schema::table('kpi_bahagian', function (Blueprint $table) {
            $table->tinyInteger('quarter')->nullable()->after('created_at')->comment('Quarter of the year');
        });

        // Add quarter column to kpi_state table
        Schema::table('kpi_states', function (Blueprint $table) {
            $table->tinyInteger('quarter')->nullable()->after('created_at')->comment('Quarter of the year');
        });

        // Add quarter column to kpi_institusi table
        Schema::table('kpi_institutions', function (Blueprint $table) {
            $table->tinyInteger('quarter')->nullable()->after('created_at')->comment('Quarter of the year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove quarter column from kpi_bahagian table
        Schema::table('kpi_bahagian', function (Blueprint $table) {
            $table->dropColumn('quarter');
        });

        // Remove quarter column from kpi_state table
        Schema::table('kpi_states', function (Blueprint $table) {
            $table->dropColumn('quarter');
        });

        // Remove quarter column from kpi_institusi table
        Schema::table('kpi_institutions', function (Blueprint $table) {
            $table->dropColumn('quarter');
        });
    }
};
