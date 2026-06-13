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
        Schema::create('alternative_flights', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('original_flight_id')
                ->constrained('flights')
                ->cascadeOnDelete();

            $table->foreignUuid('alternative_flight_id')
                ->constrained('flights')
                ->cascadeOnDelete();

            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternative_flights');
    }
};
