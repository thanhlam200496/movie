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
    Schema::table('view_history', function (Blueprint $table) {
        // Xóa khóa ngoại trước
        $table->dropForeign(['movie_id']);
        
        // Sau đó xóa cột
        $table->dropColumn('movie_id');

        // Thêm cột mới và khóa ngoại
        $table->unsignedBigInteger('episode_id');
        $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('view_history', function (Blueprint $table) {
        // Xóa khóa ngoại trước
        $table->dropForeign(['episode_id']);
        
        // Sau đó xóa cột
        $table->dropColumn('episode_id');

        // Thêm lại cột và khóa ngoại cũ
        $table->unsignedBigInteger('movie_id');
        $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
    });
}

};
