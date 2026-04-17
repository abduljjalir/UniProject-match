<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Allocation route
Route::get('/allocate', [AllocationController::class, 'runAllocation']);
Route::get('/student/{id}/project', [StudentController::class, 'myProject']);