<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasUuids, HasFilter, HasSorting;
    public $incrementing = false;
    protected $fillable = ['name', 'code', 'city', 'country', 'image'];
    protected array $searchable  = ['name', 'code', 'city', 'country'];
}
