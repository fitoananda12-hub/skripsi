<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ComplaintController as UserComplaintController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\SolutionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController;

// Test route
Route::get('/test-login', function() {
    return view('test-login');
})->name('test-login');

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes - GET login/register accessible to everyone (including authenticated users)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/register/pending', [RegisterController::class, 'showPendingPage'])->name('register.pending');

// POST login/register protected by guest and throttle middleware
Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:login');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:register');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Complaints
    Route::get('/complaints', [UserComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [UserComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [UserComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [UserComplaintController::class, 'show'])->name('complaints.show');
    
    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Complaints Management
    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{complaint}/edit', [AdminComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('complaints.update');
    Route::put('/complaints/{complaint}/assign', [AdminComplaintController::class, 'assign'])->name('complaints.assign');
    Route::put('/complaints/{complaint}/respond', [AdminComplaintController::class, 'respond'])->name('complaints.respond');
    
    // Solutions Knowledge Base
    Route::resource('solutions', SolutionController::class);
    
    // User Management - dengan fitur verifikasi registrasi
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::put('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    Route::put('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});