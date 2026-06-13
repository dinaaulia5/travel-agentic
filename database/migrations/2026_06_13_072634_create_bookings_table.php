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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('flight_id')->constrained('flights')->cascadeOnDelete();
            $table->string('booking_code')->unique();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->integer('passenger_count')->default(1);
            $table->enum('seat_class', ['economy', 'business',])->default('economy');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->enum('booking_status', ['booked', 'cancelled', 'completed'])->default('booked');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
