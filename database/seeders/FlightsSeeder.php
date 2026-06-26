<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Database\Seeder;

class FlightsSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = Airline::all();
        $airports = Airport::all();

        Flight::create([
            'airline_id' => $airlines[0]->id,
            'departure_airport_id' => $airports[0]->id,
            'arrival_airport_id' => $airports[1]->id,
            'flight_number' => 'GA101',
            'scheduled_departure' => now()->addDay()->setTime(7, 0),
            'scheduled_arrival' => now()->addDay()->setTime(9, 0),
            'price' => 1500000,
        ]);

        Flight::create([
            'airline_id' => $airlines[1]->id,
            'departure_airport_id' => $airports[0]->id,
            'arrival_airport_id' => $airports[2]->id,
            'flight_number' => 'JT203',
            'scheduled_departure' => now()->addDay()->setTime(8, 0),
            'scheduled_arrival' => now()->addDay()->setTime(10, 0),
            'price' => 900000,
        ]);

        Flight::create([
            'airline_id' => $airlines[2]->id,
            'departure_airport_id' => $airports[1]->id,
            'arrival_airport_id' => $airports[0]->id,
            'flight_number' => 'QZ801',
            'scheduled_departure' => now()->addDay()->setTime(13, 0),
            'scheduled_arrival' => now()->addDay()->setTime(15, 0),
            'price' => 1200000,
        ]);

        Flight::create([
            'airline_id' => $airlines[0]->id,
            'departure_airport_id' => $airports[2]->id,
            'arrival_airport_id' => $airports[3]->id,
            'flight_number' => 'GA205',
            'scheduled_departure' => now()->addDay()->setTime(10, 0),
            'scheduled_arrival' => now()->addDay()->setTime(12, 0),
            'price' => 1800000,
        ]);

        Flight::create([
            'airline_id' => $airlines[1]->id,
            'departure_airport_id' => $airports[0]->id,
            'arrival_airport_id' => $airports[4]->id,
            'flight_number' => 'JT501',
            'scheduled_departure' => now()->addDay()->setTime(17, 0),
            'scheduled_arrival' => now()->addDay()->setTime(19, 0),
            'price' => 750000,
        ]);
    }
}
