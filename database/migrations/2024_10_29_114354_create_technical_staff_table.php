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
        Schema::create('technical_staff', function (Blueprint $table) {
            $table->unsignedBigInteger('technicalStaff_id')->primary();
            $table->foreign('technicalStaff_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('totalPendingTask')->default(0);
            $table->integer('totalOngoingTask')->default(0);
            $table->integer('totalResolveTask')->default(0);
            $table->integer('totalRejectedTask')->default(0);
            $table->integer('totalRate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_staff');
    }
};
