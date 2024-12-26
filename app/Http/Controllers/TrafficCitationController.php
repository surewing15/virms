<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrafficCitation;
use App\Models\VehicleImpounding;
use App\Models\ViolationEntries;


class TrafficCitationController extends Controller
{
    public static function index()
    {
        $citations = TrafficCitation::where('moved_status', null)->get();
        $violations = ViolationEntries::get();
        return view('pages.citations.index', compact('citations', 'violations'));
    }


    public static function notification()
    {
        $citations = TrafficCitation::where('date', date('Y-m-d'))->get();
        $violations = ViolationEntries::get();
        return view('pages.citations.notification', compact('citations', 'violations'));
    }

    public static function violators()
    {
        $violations = ViolationEntries::get();
        $citations = TrafficCitation::select('violator_name')->distinct()->get();
        return view('pages.records.index', compact('citations', 'violations'));
    }

    public static function detail($name)
    {
        $violations = ViolationEntries::get();
        $citations = TrafficCitation::select('violator_name')->distinct()->get();

        // Fetch traffic citations with moved_status = null
        $min_cite = TrafficCitation::whereLike('violator_name', $name)
            ->where('moved_status', null)
            ->get();

        // Fetch traffic citations with stay_status = 1
        $min_cites = TrafficCitation::whereLike('violator_name', $name)
            ->where('stay_status', 1)
            ->get();

        $min_v = VehicleImpounding::whereLike('owner_name', $name)->get();

        return view('pages.records.detail', compact('citations', 'violations', 'name', 'min_cite', 'min_v', 'min_cites'));
    }


    public static function print_x($name)
    {
        $violations = ViolationEntries::get();
        $citations = TrafficCitation::select('violator_name')->distinct()->get();

        // Use the same query conditions as in detail function
        $min_cites = TrafficCitation::whereLike('violator_name', $name)
            ->where('stay_status', 1)
            ->get();

        $min_v = VehicleImpounding::whereLike('owner_name', $name)->get();

        return view('pages.records.print', compact('citations', 'violations', 'name', 'min_cites', 'min_v'));
    }

    public static function print($id)
    {
        $violations = ViolationEntries::get();
        $citations = TrafficCitation::select('violator_name')->distinct()->get();

        return view('pages.citations.print', compact('citations', 'violations', 'id'));
    }

    public static function impound($id)
    {
        $violations = ViolationEntries::get();
        $citations = TrafficCitation::select('violator_name')->distinct()->get();
        return view('pages.citations.impound', compact('citations', 'violations', 'id'));
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
            'stay_status' => 'nullable|integer',
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
            'status' => $request->inp_status,
            'stay_status' => $request->stay_status ?? 1,
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
            'status' => $request->inp_status,
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