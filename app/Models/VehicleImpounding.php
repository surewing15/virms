<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImpounding extends Model
{
    use HasFactory;
    protected $table = 't_vehicle_impoundings'; // Define table name

    protected $fillable = [
        'vehicle_number', 'owner_name', 'vehicle_type', 'violation_id', 
        'reason_for_impounding', 'date_of_impounding', 'release_date', 'fine_amount',
        'incident_location', 'document_attachment', 'photo_attachment',
        'license_no',
        'address',
        'birthdate',
        'phone',
        'reason_of_impoundment',
        'reason_of_impoundment_reason',
        'incident_address',
        'condition_x',
        'officer_name',
        'officer_rank',
    ];

    // Relationship with ViolationEntries
    public function violation()
    {
        return $this->belongsTo(ViolationEntries::class, 'violation_id');
    }
}
