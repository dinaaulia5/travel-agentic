<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = ['name', 'code', 'city', 'country', 'image'];
}
