<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Flight extends Model
{
    use HasUuids, HasFilter, HasSorting;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function departureAirport()
    {
        return $this->belongsTo(
            Airport::class,
            'departure_airport_id'
        );
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(
            Airport::class,
            'arrival_airport_id'
        );
    }

    public function flightStatus()
    {
        return $this->hasOne(
            FlightStatus::class
        );
    }
    public function agentLogs()
    {
        return $this->hasMany(
            AgentLog::class
        );
    }

    public function recommendations()
    {
        return $this->hasMany(
            AgentRecommendation::class
        );
    }

    public function alternativeFlights()
    {
        return $this->hasMany(
            AlternativeFlight::class,
            'original_flight_id'
        );
    }
}
