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
        Schema::create('agent_recommendations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->foreignUuid('flight_id')
                ->constrained('flights')
                ->cascadeOnDelete();

            $table->enum('recommendation_type', [
                'info',
                'delay_warning',
                'compensation',
                'alternative_flight',
                'refund',
                'rebooking',
            ]);

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical',
            ]);

            $table->string('title');
            $table->text('message');
            $table->text('suggested_action')->nullable();
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_recommendations');
    }
};
