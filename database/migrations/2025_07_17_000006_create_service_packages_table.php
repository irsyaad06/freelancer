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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('name', ['Starter', 'Standard', 'Premium']);
            $table->decimal('price', 12, 2)->default(0.00);
            $table->unsignedInteger('revisions')->default(0);
            $table->string('duration', 60);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};