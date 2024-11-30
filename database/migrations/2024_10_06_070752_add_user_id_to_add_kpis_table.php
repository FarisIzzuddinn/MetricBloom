<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::table('add_kpis', function (Blueprint $table) {
    //         if (!Schema::hasColumn('add_kpis', 'user_id')) {
    //             $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Make user_id nullable
    //             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //         }
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down()
    // {
    //     Schema::table('add_kpis', function (Blueprint $table) {
    //         if (Schema::hasColumn('add_kpis', 'user_id')) {
    //             $table->dropForeign(['user_id']);
    //             $table->dropColumn('user_id');
    //         }
    //     });
    // }
};
