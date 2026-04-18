<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Allocation
Route::get('/allocate', [AllocationController::class, 'runAllocation']);

// Student project view (public / app use)
Route::get('/student/{id}/project', [StudentController::class, 'myProject']);

// Admin dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// Admin CRUD
Route::prefix('admin')->group(function () {
    Route::resource('students', AdminStudentController::class);
});
Route::prefix('admin')->group(function () {
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
});