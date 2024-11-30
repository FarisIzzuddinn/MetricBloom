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
            // Add foreign key for `teras_id`
            $table->foreign('teras_id')
                  ->references('id')
                  ->on('teras')
                  ->onDelete('cascade'); // Cascade delete if a related `teras` is deleted

            // Add foreign key for `sectors_id`
            $table->foreign('sectors_id')
                  ->references('id')
                  ->on('sectors')
                  ->onDelete('cascade'); // Cascade delete if a related `sector` is deleted
        });
    }

    public function down()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            // Drop the foreign keys if rolling back
            $table->dropForeign(['teras_id']);
            $table->dropForeign(['sectors_id']);
        });
    }
};
