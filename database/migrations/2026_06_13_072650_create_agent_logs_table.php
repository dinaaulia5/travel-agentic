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
        Schema::create('agent_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('flight_id')
                ->nullable()
                ->constrained('flights')
                ->nullOnDelete();

            $table->foreignUuid('booking_id')
                ->nullable()
                ->constrained('bookings')
                ->nullOnDelete();

            $table->string('trigger_event');
            $table->integer('delay_minutes')->default(0);

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical',
            ])->nullable();

            $table->string('recommendation_type')->nullable();
            $table->text('message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_logs');
    }
};
