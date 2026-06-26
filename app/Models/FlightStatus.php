<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FlightStatus extends Model
{
    use HasUuids, HasFilter, HasSorting;
    public $incrementing = false;
    protected $table = 'flight_statuses';
    protected $fillable = ['flight_id', 'status', 'delay_minutes', 'reason', 'actual_departure', 'actual_arrival'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
