<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:HR,Finance,IT,Sales']);
    Route::get('/dashboard/presence', [DashboardController::class, 'presence']);
    //handle employees routes menggunakan resource controller
    Route::resource('/employees', EmployeeController::class)->middleware(['role:HR']);
    // handle departments routes using resource controller
    Route::resource('/departments', DepartmentController::class)->middleware(['role:HR']);
    // handle roles routes using resource controller
    Route::resource('/roles', RoleController::class)->middleware(['role:HR']);
    // handle precences routes
    Route::resource('/presences', PresenceController::class)->middleware(['role:HR,Finance,IT,Sales']);
    // handle payrolls routes
    Route::resource('/payrolls', PayrollController::class)->middleware(['role:HR,Finance,IT,Sales']);
    // handle leave requests routes
    Route::resource('/leave-requests', LeaveRequestController::class)->middleware(['role:HR,Finance,IT,Sales']);
    //handle confirmation for leave requests
    Route::get('/leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm')->middleware(['role:HR']);
    //handle rejection for leave requests
    Route::get('/leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware(['role:HR']);

    //handle tasks routes done and pending
    Route::resource('/tasks', TaskController::class)->middleware(['role:HR,Finance,IT,Sales']);
    Route::get('/tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done')->middleware(['role:HR, Finance,IT,Sales']);
    Route::get('/tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending')->middleware(['role:HR,Finance,IT,Sales']);
    Route::get('/tasks/rejected/{id}', [TaskController::class, 'rejected'])->name('tasks.rejected')->middleware(['role:HR,Finance,IT,Sales']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
