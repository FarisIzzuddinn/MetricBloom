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
            $table->unsignedBigInteger('institution_id')->nullable()->after('id'); // Adjust the position as needed
        });
    }

    public function down()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            $table->dropColumn('institution_id');
        });
    }
};
