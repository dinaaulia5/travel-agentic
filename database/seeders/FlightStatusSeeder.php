<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\FlightStatus;
use Illuminate\Database\Seeder;

class FlightStatusSeeder extends Seeder
{
    public function run(): void
    {
        $flights = Flight::all();

        FlightStatus::create([
            'flight_id' => $flights[0]->id,
            'status' => 'on_time',
            'delay_minutes' => 0,
        ]);

        FlightStatus::create([
            'flight_id' => $flights[1]->id,
            'status' => 'delayed',
            'delay_minutes' => 90,
            'reason' => 'Bad Weather',
        ]);

        FlightStatus::create([
            'flight_id' => $flights[2]->id,
            'status' => 'boarding',
            'delay_minutes' => 0,
        ]);

        FlightStatus::create([
            'flight_id' => $flights[3]->id,
            'status' => 'arrived',
            'delay_minutes' => 0,
            'actual_departure' => now()->subHours(3),
            'actual_arrival' => now()->subHour(),
        ]);

        FlightStatus::create([
            'flight_id' => $flights[4]->id,
            'status' => 'cancelled',
            'delay_minutes' => 0,
            'reason' => 'Technical Issue',
        ]);
    }
}
