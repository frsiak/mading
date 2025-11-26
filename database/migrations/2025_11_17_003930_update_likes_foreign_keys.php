<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_artikel']);
            
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_artikel')->references('id_artikel')->on('artikel')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_artikel']);
            
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_artikel')->references('id_artikel')->on('artikel');
        });
    }
};