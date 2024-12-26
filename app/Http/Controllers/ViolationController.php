<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViolationEntries;

class ViolationController extends Controller
{
    public static function index()
    {
        $violations = ViolationEntries::get();
        return view('pages.violations.entries', compact('violations'));
    }


    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'inp_violation' => 'required|string|max:255',
            'inp_penalty' => 'required|numeric|min:0',
        ]);

        // Create a new violation record
        ViolationEntries::create([
            'violation' => $request->inp_violation,
            'penalty' => $request->inp_penalty,
        ]);

        // Redirect to a page (or back) with a success message
        return redirect()->back()->with('success', 'Violation saved successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'inp_violation' => 'required|string|max:255',
            'inp_penalty' => 'required|numeric|min:0',
        ]);

        // Find the existing violation record by ID
        $violation = ViolationEntries::find($id);

        if ($violation) {
            // Update the violation record with new data
            $violation->update([
                'violation' => $request->inp_violation,
                'penalty' => $request->inp_penalty,
            ]);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Violation updated successfully!');
        }

        // Return an error if the violation is not found
        return redirect()->back()->with('error', 'Violation not found.');
    }

    public function remove(Request $request)
    {
        // Validate the ID being passed
        $request->validate([
            'id' => 'required|integer|exists:t_entries_violations,id'
        ]);

        // Find the violation by ID and delete it
        $violation = ViolationEntries::find($request->id);
        if ($violation) {
            $violation->delete();
            return response()->json(['success' => 'Violation deleted successfully.']);
        }

        return response()->json(['error' => 'Violation not found.'], 404);
    }
}
