<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectQualityController;

use App\Models\Project;
use App\Models\ProjectAllocation;
use App\Models\ProjectMember;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/delete', function (Request $request) {
    $id = $request->push_id;
    User::where('id', $id)->delete();
});
