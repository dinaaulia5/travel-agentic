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
        Schema::create('flights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('airline_id')->constrained('airlines')->cascadeOnDelete();
            $table->foreignUuid('departure_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->foreignUuid('arrival_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->string('flight_number')->unique();
            $table->timestamp('scheduled_departure');
            $table->timestamp('scheduled_arrival');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
