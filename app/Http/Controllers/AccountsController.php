<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
// use App\Models\Program;
use App\Models\ApplicationModel;
use App\Models\ParameterModel;
use App\Models\InstrumentModel;
use App\Models\InstrumentSubModel;
use App\Models\InstrumentSubListModel;
use App\Models\AreaModel;
use App\Models\CourseModel;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class AccountsController extends Controller
{

    public static function index()
    {   
        $accounts = User::get();
        return view('pages.accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // confirmed ensures password matches password_confirmation
        ]);

        // Create the new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'password' => Hash::make($request->password), // Hash the password before saving
        ]);

        // Redirect with a success message
        return redirect()->back()->with(['success' => 'Registration successful!']);
    }

}
