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
        Schema::create('room_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->index();
            $table->date('date')->index();
            $table->enum('status', ['normal_checkout', 'early_checkin', 'early_checkout', 'late_checkout', 'booked'])->default('booked');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->timestamps();

            $table->unique(['room_id', 'date']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_statuses');
    }
};
