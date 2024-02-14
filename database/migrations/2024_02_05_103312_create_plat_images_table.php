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
        Schema::create('plat_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plat_id');
            $table->string('image');

            $table->foreign('plat_id')->references('id')->on('plats')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plat_images');
    }
};
