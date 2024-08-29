<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToAddKpisTable extends Migration
{
    public function up()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            // Check if the column exists before adding
            if (!Schema::hasColumn('add_kpis', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('add_kpis', function (Blueprint $table) {
            if (Schema::hasColumn('add_kpis', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}

