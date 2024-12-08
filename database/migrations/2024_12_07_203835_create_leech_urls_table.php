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
        Schema::create('leech_urls', function (Blueprint $table) {
            $table->id();
            $table->string('name',20);
            $table->string('url_list_movie')->nullable();
            $table->string('url_poster')->nullable();
            $table->string('url_video_m3u8')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leech_urls');
    }
};
