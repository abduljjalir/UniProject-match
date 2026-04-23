<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SpecialityController;
use App\Http\Controllers\Admin\SelectionController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ALLOCATION
|--------------------------------------------------------------------------
*/

Route::get('/allocate', [AllocationController::class, 'runAllocation']);

/*
|--------------------------------------------------------------------------
| PUBLIC STUDENT VIEW
|--------------------------------------------------------------------------
*/

Route::get('/student/{id}/project', [StudentController::class, 'myProject']);

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('admins', AdminController::class);

    Route::resource('students', AdminStudentController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'store']);
    Route::resource('professors', ProfessorController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('specialities', SpecialityController::class);
    Route::resource('allocations', AllocationController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('selections', SelectionController::class);
    Route::post('/students/{student}/reset-password', [AdminStudentController::class, 'resetPassword'])
    ->name('students.resetPassword');
    Route::post('/settings/student/{id}/reset-password', 
    [SettingController::class, 'resetStudentPassword'])
    ->name('settings.student.reset');

Route::post('/settings/professor/{id}/reset-password', 
    [SettingController::class, 'resetProfessorPassword'])
    ->name('settings.professor.reset');


});