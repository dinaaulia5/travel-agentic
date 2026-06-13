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
        Schema::create('booking_passengers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->string('full_name');

            $table->enum('passenger_type', [
                'adult',
                'child',
                'infant',
            ])->default('adult');

            $table->enum('identity_type', [
                'nik',
                'passport',
            ])->default('nik');

            $table->string('identity_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_passengers');
    }
};
