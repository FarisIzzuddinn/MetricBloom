<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('kpi_state', function (Blueprint $table) {
    //         $table->unsignedBigInteger('user_id')->after('kpi_id'); // Adjust the position if necessary
    //         // If you want to make it a foreign key:
    //         //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('kpi_state', function (Blueprint $table) {
    //         $table->dropColumn('user_id');
    //     });
    // }
};
