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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->year('release_year');
            $table->integer('age_rating')->nullable();  // Đổi tên thành age_rating nếu là độ tuổi khuyến nghị
            $table->integer('duration');  // Thời gian phim (phút)
            $table->text('countries')->nullable();  // Nếu có thể nhiều quốc gia
            $table->string('director')->nullable();
            $table->float('rating', 2, 1)->nullable();
            $table->enum('type_film', ['TV Show', 'Movie']);
            $table->string('poster_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->enum('status', ['Hidden', 'Public', 'Not Released']);
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
