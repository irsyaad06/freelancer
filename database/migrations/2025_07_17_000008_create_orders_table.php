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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke freelancer dan paket yang dipilih
            $table->foreignId('freelancer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_package_id')->constrained()->onDelete('cascade');

            // Info pembeli
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_whatsapp');

            // Detail pekerjaan yang diberikan
            $table->text('job_description')->nullable();
            $table->string('attachment_file')->nullable(); // path upload file

            // Status order
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
