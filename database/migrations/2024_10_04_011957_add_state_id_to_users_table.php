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
        Schema::table('users', function (Blueprint $table) {
            // Add state_id column
            $table->unsignedBigInteger('state_id')->nullable()->after('email');
            
            // Set up the foreign key constraint
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint and the state_id column
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });
    }
};
