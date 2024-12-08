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
        Schema::table('leech_urls', function (Blueprint $table) {
            
            $table->string('url_detail')->nullable();
            
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leech_urls', function (Blueprint $table) {
            
            $table->dropColumn('url_detail');
            
           
        });
    }
};
