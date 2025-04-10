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
        Schema::create('faculties', function (Blueprint $table) {

            $table->unsignedBigInteger('faculty_id')->primary();

            $table->foreign('faculty_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('site', ['New Site', 'Old Site']);

            $table->string('officeOrBuilding');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
