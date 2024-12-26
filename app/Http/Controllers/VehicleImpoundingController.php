<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\VehicleImpounding;
use App\Models\ViolationEntries;
use App\Models\TrafficCitation;
use Illuminate\Http\Request;

class VehicleImpoundingController extends Controller
{
    public function index()
    {
        // Get all impoundings with their associated violationw
        $impoundings = VehicleImpounding::get();
        $violations = ViolationEntries::get();
        return view('pages.impoundings.index', compact('impoundings', 'violations'));
    }

    public function print($id)
    {
        // Get all impoundings with their associated violationw
        $impoundings = VehicleImpounding::get();
        $violations = ViolationEntries::get();
        return view('pages.impoundings.print', compact('impoundings', 'violations', 'id'));
    }

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'vehicle_type' => 'required|string|max:255',
            'vehicle_number' => 'nullable|string|max:20',
            'owner_name' => 'required|string|max:255',
            'date_of_impounding' => 'required|date',
            'reason_for_impounding' => 'nullable|string|max:255',
            'fine_amount' => 'nullable|numeric|min:0',
            'release_date' => 'nullable|date',
            'incident_location' => 'required|string|max:255',  // New input validation
            'violation_id' => 'required|array',
            'violation_id.*' => 'exists:t_entries_violations,id',
            'document_attachment.*' => 'nullable|mimes:pdf,doc,docx|max:2048',  // Supporting documents validation
            'photo_attachment.*' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',  // Image validation
        ]);

        // Serialize the violations array
        $violationsArray = json_encode($request->violation_id);

        // Handle file uploads
        $documentPaths = [];
        if ($request->hasFile('document_attachment')) {
            foreach ($request->file('document_attachment') as $file) {
                $documentPaths[] = $file->store('documents', 'public');
            }
        }

        $photoPaths = [];
        if ($request->hasFile('photo_attachment')) {
            foreach ($request->file('photo_attachment') as $file) {
                $photoPaths[] = $file->store('photos', 'public');
            }
        }

        // Create a new vehicle impounding record, including the new inputs
        VehicleImpounding::create([
            'vehicle_type' => $request->vehicle_type,
            'vehicle_number' => $request->vehicle_number,
            'owner_name' => $request->owner_name,
            'date_of_impounding' => $request->date_of_impounding,
            'reason_for_impounding' => $request->reason_for_impounding,
            'fine_amount' => $request->fine_amount,
            'release_date' => $request->release_date,
            'violation_id' => $violationsArray,
            'license_no' => $request->license_no,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
            'reason_of_impoundment' => json_encode($request->reason_of_impoundment),
            'reason_of_impoundment_reason' => $request->reason_of_impoundment_reason,
            'incident_address' => $request->incident_address,
            'condition_x' => $request->condition_x,
            'incident_location' => $request->incident_location,  // New input
            'document_attachment' => json_encode($documentPaths),  // Store file paths
            'photo_attachment' => json_encode($photoPaths),  // Store image paths
        ]);

        TrafficCitation::where('id', $request->id_x)->update(['moved_status' => null]);
        TrafficCitation::where('id', $request->id_x)->update(['moved_status' => 1]);

        // Redirect to a page (or back) with a success message
        return redirect('impoundings');
    }

    public function update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'vehicle_type' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:20',
            'owner_name' => 'required|string|max:255',
            'date_of_impounding' => 'required|date',
            'reason_for_impounding' => 'nullable|string|max:255',
            'fine_amount' => 'nullable|numeric|min:0',
            'release_date' => 'nullable|date', // Store file paths
            'violation_id' => 'required|array', // Ensure violation_id is an array (for multiple violations)
            'violation_id.*' => 'exists:t_entries_violations,id', // Ensure each violation exists in the database
        ]);

        // Serialize the violations array
        $violationsArray = json_encode($request->violation_id);  // Converts the array to a JSON format

        // Find the existing vehicle impounding record by ID
        $vehicleImpounding = VehicleImpounding::findOrFail($id);

        $documentPaths = [];
        if ($request->hasFile('document_attachment')) {
            foreach ($request->file('document_attachment') as $file) {
                $documentPaths[] = $file->store('documents', 'public');
            }
        }

        // Update the vehicle impounding record with the new values
        $vehicleImpounding->update([
            'vehicle_type' => $request->vehicle_type,
            'vehicle_number' => $request->vehicle_number,
            'owner_name' => $request->owner_name,
            'date_of_impounding' => $request->date_of_impounding,
            'reason_for_impounding' => json_encode($request->reason_of_impoundment),
            'reason_of_impoundment_reason' => $request->reason_of_impoundment_reason,
            'fine_amount' => $request->fine_amount,
            'release_date' => $request->release_date,
            'officer_name' => $request->officer_name,
            'officer_rank' => $request->officer_rank,
            'document_attachment' => json_encode($documentPaths),
            'violation_id' => $violationsArray,  // Save violations array into this field
        ]);

        // Redirect to a page (or back) with a success message
        return redirect()->back()->with('success', 'Vehicle impounding record updated successfully!');
    }

    public function remove(Request $request)
    {
        // Validate the ID being passed
        $request->validate([
            'id' => 'required|integer|exists:t_vehicle_impoundings,id'
        ]);

        // Find the violation by ID and delete it
        $violation = VehicleImpounding::find($request->id);
        if ($violation) {
            $violation->delete();
            return response()->json(['success' => 'Record deleted successfully.']);
        }

        return response()->json(['error' => 'Record not found.'], 404);
    }
}