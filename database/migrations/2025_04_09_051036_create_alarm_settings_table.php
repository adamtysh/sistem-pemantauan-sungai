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
        Schema::create('alarm_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->bigInteger('sensor_setting_id')->unsigned()->nullable();
            $table->string('operator')->nullable();
            $table->double('threshold')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->default('active');
            // Foreign key constraints
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('sensor_setting_id')->references('id')->on('sensor_settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alarm_settings');
    }
};
