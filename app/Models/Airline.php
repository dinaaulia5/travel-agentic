<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class Airline extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = ['name', 'code', 'logo'];
}
