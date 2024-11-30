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
        Schema::table('kpi_states', function (Blueprint $table) {
            $table->decimal('pencapaian', 10, 2)->default(0)->after('state_id');
            $table->decimal('peratus_pencapaian', 10, 2)->default(0)->after('pencapaian');
            $table->string('status')->default('not achieved')->after('peratus_pencapaian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kpi_states', function (Blueprint $table) {
            $table->dropColumn(['pencapaian', 'peratus_pencapaian', 'status']);
        });
    }
};
