<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationEntries extends Model
{
    use HasFactory;
    protected $table = 't_entries_violations';
    protected $fillable = ['violation', 'penalty'];

    public function vehicleImpoundings()
    {
        return $this->hasMany(VehicleImpounding::class, 'violation_id');
    }
}
