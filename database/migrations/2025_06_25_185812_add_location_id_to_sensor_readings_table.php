<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensor_readings', function (Blueprint $table) {
            // Tambahkan kolom foreign key untuk location_id setelah kolom 'id'
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('cascade')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('sensor_readings', function (Blueprint $table) {
            // Cara untuk menghapus kolom jika migrasi di-rollback
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};
