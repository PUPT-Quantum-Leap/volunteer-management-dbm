<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendancePerformanceController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrgChartController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PollManagementController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Any Logged-in User)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Volunteer registration form (authenticated users can register as volunteers)
    Route::get('/volunteer-form', function () {
        return view('volunteer-form');
    });
    Route::post('/volunteer-register', [VolunteerController::class, 'store']);

    // Org Chart - View only (both admin and volunteer can view)
    Route::get('/org-chart', [OrgChartController::class, 'show']);

    // Poll voting - Both roles can vote
    Route::post('/api/polls/{poll}/vote', [PollController::class, 'vote']);
});

/*
|--------------------------------------------------------------------------
| Volunteer Routes (Volunteers Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:volunteer'])->group(function () {
    // Volunteer Dashboard - volunteers can view/edit their own profile
    Route::get('/volunteer/{id}/dashboard', [VolunteerDashboardController::class, 'show'])->name('volunteer.dashboard');
    Route::put('/volunteer/{id}/update', [VolunteerDashboardController::class, 'update'])->name('volunteer.update');
    Route::delete('/volunteer/{id}/delete', [VolunteerDashboardController::class, 'delete'])->name('volunteer.delete');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admins Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Poll Management - Admin only
    Route::get('/polls/create', [PollManagementController::class, 'create']);
    Route::post('/polls/create', [PollManagementController::class, 'store']);
    Route::get('/polls/manage', [PollManagementController::class, 'index']);
    Route::delete('/polls/{poll}/delete', [PollManagementController::class, 'destroy']);

    // Attendance and Performance recording - Admin only
    Route::post('/volunteer/{id}/attendance', [AttendancePerformanceController::class, 'recordAttendance'])->name('attendance.record');
    Route::post('/volunteer/{id}/performance', [AttendancePerformanceController::class, 'recordPerformance'])->name('performance.record');
    Route::get('/api/volunteer/{id}/attendance-stats', [AttendancePerformanceController::class, 'getAttendanceStats']);
    Route::get('/api/volunteer/{id}/performance-summary', [AttendancePerformanceController::class, 'getPerformanceSummary']);

    // Auto Assignments - Admin only
    Route::get('/auto-assignments', [AssignmentController::class, 'show']);
    Route::post('/api/assignments/generate', [AssignmentController::class, 'generate']);
    Route::post('/api/assignments/save', [AssignmentController::class, 'save']);
});

// Admin Dashboard Routes - Admin only
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Volunteer Management
    Route::get('/volunteers', [AdminDashboardController::class, 'volunteers'])->name('admin.volunteers');
    Route::post('/volunteers', [AdminDashboardController::class, 'volunteerStore'])->name('admin.volunteer.store');
    Route::get('/api/volunteers', [AdminDashboardController::class, 'volunteersApi'])->name('admin.volunteers.api');
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

    // Poll Management
    Route::get('/polls', [PollManagementController::class, 'index'])->name('admin.polls');

    // Backup Management
    Route::get('/backup', [BackupController::class, 'index'])->name('admin.backup');
    Route::get('/backup/list', [BackupController::class, 'list'])->name('admin.backup.list');
    Route::post('/backup/create', [BackupController::class, 'create'])->name('admin.backup.create');
    Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('admin.backup.download');
    Route::delete('/backup/{filename}', [BackupController::class, 'delete'])->name('admin.backup.delete');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('admin.backup.restore');
    
    // Chatbot
    Route::post('/chatbot', [ChatbotController::class, 'sendMessage'])->name('admin.chatbot');
});
