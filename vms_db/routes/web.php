<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendancePerformanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PollManagementController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', [SignupController::class, 'store']);

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/volunteer-form', function () {
        return view('volunteer-form');
    });

    Route::post('/volunteer-register', [VolunteerController::class, 'store']);
});

Route::get('/volunteer/{id}/dashboard', [VolunteerDashboardController::class, 'show'])->name('volunteer.dashboard');
Route::put('/volunteer/{id}/update', [VolunteerDashboardController::class, 'update'])->name('volunteer.update');
Route::delete('/volunteer/{id}/delete', [VolunteerDashboardController::class, 'delete'])->name('volunteer.delete');

// API vote endpoint
Route::post('/api/polls/{poll}/vote', [PollController::class, 'vote']);

// Poll management routes
Route::get('/polls/create', [PollManagementController::class, 'create']);
Route::post('/polls/create', [PollManagementController::class, 'store']);
Route::get('/polls/manage', [PollManagementController::class, 'index']);
Route::delete('/polls/{poll}/delete', [PollManagementController::class, 'destroy']);

// Attendance and Performance routes
Route::post('/volunteer/{id}/attendance', [AttendancePerformanceController::class, 'recordAttendance'])->name('attendance.record');
Route::post('/volunteer/{id}/performance', [AttendancePerformanceController::class, 'recordPerformance'])->name('performance.record');
Route::get('/api/volunteer/{id}/attendance-stats', [AttendancePerformanceController::class, 'getAttendanceStats']);
Route::get('/api/volunteer/{id}/performance-summary', [AttendancePerformanceController::class, 'getPerformanceSummary']);

Route::get('/org-chart', [App\Http\Controllers\OrgChartController::class, 'show']);
Route::get('/auto-assignments', [App\Http\Controllers\AssignmentController::class, 'show']);
Route::post('/api/assignments/generate', [App\Http\Controllers\AssignmentController::class, 'generate']);
Route::post('/api/assignments/save', [App\Http\Controllers\AssignmentController::class, 'save']);

// Admin Dashboard Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Volunteer Management
    Route::get('/volunteers', [AdminDashboardController::class, 'volunteers'])->name('admin.volunteers');
    Route::get('/volunteer/{id}', [AdminDashboardController::class, 'volunteerShow'])->name('admin.volunteer.show');
    Route::put('/volunteer/{id}', [AdminDashboardController::class, 'volunteerUpdate'])->name('admin.volunteer.update');
    Route::delete('/volunteer/{id}', [AdminDashboardController::class, 'volunteerDelete'])->name('admin.volunteer.delete');

    // Attendance Management
    Route::get('/attendance', [AdminDashboardController::class, 'attendance'])->name('admin.attendance');
    Route::post('/attendance/record', [AdminDashboardController::class, 'recordAttendance'])->name('admin.attendance.record');

    // Performance Management
    Route::get('/performance', [AdminDashboardController::class, 'performance'])->name('admin.performance');
    Route::post('/performance/record', [AdminDashboardController::class, 'recordPerformance'])->name('admin.performance.record');

    // Org Chart Management
    Route::get('/org-chart', [AdminDashboardController::class, 'orgChart'])->name('admin.org-chart');
    Route::post('/org-chart', [AdminDashboardController::class, 'updateOrgChart'])->name('admin.org-chart.update');
});
