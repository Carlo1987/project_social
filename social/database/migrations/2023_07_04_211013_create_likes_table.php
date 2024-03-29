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
       Schema::create('likes', function (Blueprint $table) {
          $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('video_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('video_id')->references('id')->on('videos');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
