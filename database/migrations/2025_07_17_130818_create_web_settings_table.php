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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_web')->nullable();
            $table->string('nama_web');
            $table->text('deskripsi_web')->nullable();
            $table->string('alamat_web')->nullable();
            $table->string('email_web')->nullable();
            $table->string('telepon_web')->nullable();
            $table->string('facebook_web')->nullable();
            $table->string('instagram_web')->nullable();
            $table->string('twitter_web')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
