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
        Schema::create('kpi_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained('add_kpis')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ensure users are linked
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpi_user');
    }
};
