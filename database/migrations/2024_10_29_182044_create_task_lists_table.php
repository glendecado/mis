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
        Schema::create('task_lists', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');

            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');


            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            
            $table->string('task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_lists');
    }
};
