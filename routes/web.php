<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\TrafficCitationController;
use App\Http\Controllers\VehicleImpoundingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountsController;

use App\Models\VehicleImpounding;
use App\Models\ViolationEntries;
use App\Models\TrafficCitation;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {        
        // if(Auth::user()->account_type == 'Officer'){
        //     return redirect('/impoundings');
        // }else{
            $citations = TrafficCitation::get();        
            $impoundings = VehicleImpounding::get();
            $violations = ViolationEntries::get();
    
            $impoundings_count = VehicleImpounding::all();
    
            return view('dashboard', compact('citations', 'violations', 'impoundings', 'impoundings_count'));
        //}
       
    });

     // ** Impoundings ** //
     Route::get('/impoundings', [VehicleImpoundingController::class, 'index']);
     Route::get('/impoundings/print/{id}', [VehicleImpoundingController::class, 'print']);
     Route::post('/impoundings/store', [VehicleImpoundingController::class, 'store'])->name('vehicle-impoundings.store');
     Route::post('/impoundings/entry/remove', [VehicleImpoundingController::class, 'remove'])->name('impounding.remove');
     Route::post('/impoundings/update/{id}', [VehicleImpoundingController::class, 'update'])->name('vehicle-impoundings.update');

    // ** Violations ** //
    Route::get('/violations', [ViolationController::class, 'index']);
    Route::post('/violations/entry/store', [ViolationController::class, 'store'])->name('violations.entry.store');
    Route::post('/violations/entry/remove', [ViolationController::class, 'remove'])->name('violation.entry.remove');
    Route::post('/violations/entry/update/{id}', [ViolationController::class, 'update'])->name('violation.entry.update');
    
    // ** Trafic Citations ** //
    Route::get('/notification', [TrafficCitationController::class, 'notification']);
    Route::get('/citations', [TrafficCitationController::class, 'index']);
    Route::post('/citations/store', [TrafficCitationController::class, 'store'])->name('citations.store');
    Route::post('/citations/remove', [TrafficCitationController::class, 'remove'])->name('citations.remove');
    Route::post('/citations/update/{id}', [TrafficCitationController::class, 'update'])->name('citations.update');

    Route::get('/violators', [TrafficCitationController::class, 'violators']);
    Route::get('/violators/detail/{id}', [TrafficCitationController::class, 'detail']);
    Route::get('/violators/print/{id}', [TrafficCitationController::class, 'print']);
    Route::get('/violators/impound/{id}', [TrafficCitationController::class, 'impound']);
    Route::get('/violators/print/{id}', [TrafficCitationController::class, 'print_x']);

    // ** Budget Allocation ** //
    Route::get('/lgu/dashboard', function () {
        return redirect('/inventory');
    });


    // ** Projects ** //
    // Route::get('/projects', [ProjectController::class, 'index']);
    // Route::get('/projects/details/{id}', [ProjectController::class, 'details']);
    // Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    // Route::post('/projects/update', [ProjectController::class, 'update'])->name('projects.update');

    // // ** Employee ** //    
    // Route::get('/employee', [EmployeeController::class, 'index']);
    // Route::post('/employee/registration', [EmployeeController::class, 'store'])->name('employee.save');

    // ** Reports ** //    
    Route::get('/generate-report', [ReportController::class, 'generate']);
    Route::get('/revenue-report', [ReportController::class, 'index']);

    Route::get('/generate-report/print', [ReportController::class, 'generate_print']);

    //Route::get('/reports', [ReportsController::class, 'index']);
    // Route::get('/reports/print', [ReportsController::class, 'print']);
    // Route::get('/projects/print/{id}', [ProjectController::class, 'print_checklist']);    

    // // ** Resources ** //    
    // Route::get('/resources', [ResourcesController::class, 'index']);
    // Route::post('/resources/registration', [ResourcesController::class, 'store'])->name('resources.save');

     /* Accounts */
     Route::get('/accounts', [AccountsController::class, 'index']);
     Route::post('/register', [AccountsController::class, 'store'])->name('register.store');

});
