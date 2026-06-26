<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AirportsSeeder extends Seeder
{
    public function run(): void
    {
        Airport::insert([
            [
                'id' => Str::uuid(),
                'code' => 'CGK',
                'name' => 'Soekarno Hatta International Airport',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'image' => null,
            ],
            [
                'id' => Str::uuid(),
                'code' => 'DPS',
                'name' => 'Ngurah Rai International Airport',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'image' => null,
            ],
            [
                'id' => Str::uuid(),
                'code' => 'SUB',
                'name' => 'Juanda International Airport',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
                'image' => null,
            ],
            [
                'id' => Str::uuid(),
                'code' => 'UPG',
                'name' => 'Sultan Hasanuddin Airport',
                'city' => 'Makassar',
                'country' => 'Indonesia',
                'image' => null,
            ],
            [
                'id' => Str::uuid(),
                'code' => 'YIA',
                'name' => 'Yogyakarta International Airport',
                'city' => 'Yogyakarta',
                'country' => 'Indonesia',
                'image' => null,
            ],
        ]);
    }
}
