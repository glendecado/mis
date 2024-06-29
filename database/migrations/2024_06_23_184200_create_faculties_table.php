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
            $table->unsignedBigInteger('faculties_id')->primary();
            $table->foreign('faculties_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('college');
            $table->string('building');
            $table->string('room');
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
