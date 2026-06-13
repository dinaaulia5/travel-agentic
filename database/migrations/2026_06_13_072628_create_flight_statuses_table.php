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
        Schema::create('flight_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('flight_id')->constrained('flights')->cascadeOnDelete();
            $table->enum('status', [
                'on_time',
                'boarding',
                'delayed',
                'departed',
                'arrived',
                'cancelled',
            ])->default('on_time');
            $table->integer('delay_minutes')->default(0);
            $table->text('reason')->nullable();
            $table->timestamp('actual_departure')->nullable();
            $table->timestamp('actual_arrival')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_statuses');
    }
};
