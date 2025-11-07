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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
$table->string('name',50);
$table->string('email',50);
$table->unsignedBigInteger("episode_id");
            $table->text("content");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
