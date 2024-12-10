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
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('report_name'); // Report Name
            $table->unsignedBigInteger('generated_by'); // User Who Generated the Report
            $table->text('filter_criteria')->nullable(); // JSON String of Filters
            $table->timestamps(); // Created At

            // Foreign Key Constraint
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
