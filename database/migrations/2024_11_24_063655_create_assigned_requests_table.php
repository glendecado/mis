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
        Schema::create('assigned_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('technicalStaff_id');


            $table->foreign('technicalStaff_id')->references('technicalStaff_id')->on('technical_staff')->onDelete('cascade');


            $table->unsignedBigInteger('request_id');


            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_requests');
    }
};
