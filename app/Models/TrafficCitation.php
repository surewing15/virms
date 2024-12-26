<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficCitation extends Model
{
    use HasFactory;
    protected $table = 't_traffic_citations';
    protected $fillable = [
        'plate_number',
        'violator_name',
        'moved_status',
        'address',
        'date',
        'municipal_ordinance_number',
        'specific_offense',
        'remarks',
        'status',
    ];
}
