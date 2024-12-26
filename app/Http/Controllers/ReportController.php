<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrafficCitation;
use App\Models\VehicleImpounding;
use App\Models\ViolationEntries;


class ReportController extends Controller
{
    public static function index()
    {
        $citations = TrafficCitation::get();
        $impoundings = VehicleImpounding::where('release_date', '<>', null)->get();
        $violations = ViolationEntries::get();

        $impoundings_count = VehicleImpounding::all();

        return view('pages.revenue.index', compact('citations', 'violations', 'impoundings', 'impoundings_count'));
    }

    public static function generate()
    {
        $impoundings = VehicleImpounding::get();
        $citations = TrafficCitation::get();

        $violations = ViolationEntries::get();

        $impoundings_count = VehicleImpounding::all();

        return view('pages.reports.index', compact('citations', 'violations', 'impoundings', 'impoundings_count'));
    }

    public static function generate_print()
    {
        $impoundings = VehicleImpounding::get();
        $citations = TrafficCitation::get();

        $violations = ViolationEntries::get();

        $impoundings_count = VehicleImpounding::all();

        return view('pages.reports.print', compact('citations', 'violations', 'impoundings', 'impoundings_count'));
    }

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'plate_number' => 'required|string|max:255',
            'violator_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'municipal_ordinance_number' => 'required|string|max:255',
            'specific_offense' => 'required|array',
            'remarks' => 'nullable|string|max:255',
        ]);

        $violationsArray = json_encode($request->specific_offense);

        // Create a new traffic citation record
        TrafficCitation::create([
            'plate_number' => $request->plate_number,
            'violator_name' => $request->violator_name,
            'address' => $request->address,
            'date' => $request->date,
            'municipal_ordinance_number' => $request->municipal_ordinance_number,
            'specific_offense' => $violationsArray,
            'remarks' => $request->remarks,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Traffic citation saved successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'plate_number' => 'required|string|max:255',
            'violator_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'municipal_ordinance_number' => 'required|string|max:255',
            'specific_offense' => 'required|array',
            'remarks' => 'nullable|string|max:255',
        ]);

        $violationsArray = json_encode($request->specific_offense);

        // Find the existing traffic citation record by ID
        $citation = TrafficCitation::findOrFail($id);

        // Update the traffic citation record with new data
        $citation->update([
            'plate_number' => $request->plate_number,
            'violator_name' => $request->violator_name,
            'address' => $request->address,
            'date' => $request->date,
            'municipal_ordinance_number' => $request->municipal_ordinance_number,
            'specific_offense' => $violationsArray,
            'remarks' => $request->remarks,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Traffic citation updated successfully!');
    }

    public function remove(Request $request)
    {
        // Validate the ID being passed
        $request->validate([
            'id' => 'required|integer|exists:t_traffic_citations,id'
        ]);

        // Find the traffic citation by ID and delete it
        $citation = TrafficCitation::find($request->id);
        if ($citation) {
            $citation->delete();
            return response()->json(['success' => 'Traffic citation deleted successfully.']);
        }

        return response()->json(['error' => 'Traffic citation not found.'], 404);
    }
}
