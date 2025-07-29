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
        Schema::table('service_packages', function (Blueprint $table) {
            // Tambahkan unique constraint untuk kombinasi freelancer_id, subcategory_id, dan title
            $table->unique(['freelancer_id', 'subcategory_id', 'title'], 'unique_freelancer_subcategory_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_packages', function (Blueprint $table) {
            // Hapus unique constraint
            $table->dropUnique('unique_freelancer_subcategory_title');
        });
    }
};
