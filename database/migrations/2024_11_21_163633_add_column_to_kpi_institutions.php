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
        Schema::table('kpi_institutions', function (Blueprint $table) {
            $table->decimal('pencapaian', 10, 2)->default(0)->after('institution_id');
            $table->decimal('peratus_pencapaian', 10, 2)->default(0)->after('pencapaian');
            $table->string('status')->default('not achieved')->after('peratus_pencapaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpi_institutions', function (Blueprint $table) {
            //
        });
    }
};
