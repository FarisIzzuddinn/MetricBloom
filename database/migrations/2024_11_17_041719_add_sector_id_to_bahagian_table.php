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
    //     Schema::table('bahagian', function (Blueprint $table) {
    //         $table->unsignedBigInteger('sector_id')->nullable()->after('nama_bahagian'); // Add sector_id column
    //         $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade'); // Foreign key relationship
    //     });
    // }

    // public function down()
    // {
    //     Schema::table('bahagian', function (Blueprint $table) {
    //         $table->dropForeign(['sector_id']); // Drop the foreign key
    //         $table->dropColumn('sector_id'); // Drop the column
    //     });
    // }
};
