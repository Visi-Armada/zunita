<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PublicAuthController;
use App\Http\Controllers\PublicUserController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Dashboard - Main Page
Route::get('/', function () {
    return view('home');
})->name('home');

// API Routes for dashboard data
Route::prefix('api')->group(function () {
    Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData']);
    Route::get('/real-time-stats', [DashboardController::class, 'getRealTimeStats']);
});

// Public User Authentication Routes
Route::prefix('auth')->group(function () {
    // Registration
    Route::get('/register', [PublicAuthController::class, 'showRegisterForm'])->name('public.register');
    Route::post('/register', [PublicAuthController::class, 'register']);
    
    // Login
    Route::get('/login', [PublicAuthController::class, 'showLoginForm'])->name('public.login');
    Route::post('/login', [PublicAuthController::class, 'login']);
    
    // Logout
    Route::post('/logout', [PublicAuthController::class, 'logout'])->name('public.logout');
});

// Protected Public User Routes
Route::middleware(['auth:public'])->prefix('user')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PublicUserController::class, 'dashboard'])->name('public.dashboard');
    
    // Profile
    Route::get('/profile', [PublicUserController::class, 'profile'])->name('public.profile');
    Route::post('/profile', [PublicUserController::class, 'updateProfile']);
    
    // Notifications
    Route::get('/notifications', [PublicUserController::class, 'notifications'])->name('public.notifications');
    Route::post('/notifications/{notification}/read', [PublicUserController::class, 'markNotificationAsRead'])->name('public.notifications.read');
    
    // My Submissions
    Route::get('/submissions', [PublicUserController::class, 'mySubmissions'])->name('public.submissions');
    
    // Forms
    Route::prefix('forms')->group(function () {
        // Complaints
        Route::get('/complaint', [FormController::class, 'showComplaintForm'])->name('public.forms.complaint');
        Route::post('/complaint', [FormController::class, 'storeComplaint'])->name('public.forms.complaint.store');
        
        // Applications
        Route::get('/application', [FormController::class, 'showApplicationForm'])->name('public.forms.application');
        Route::post('/application', [FormController::class, 'storeApplication'])->name('public.forms.application.store');
        
        // Initiatives
        Route::get('/initiative', [FormController::class, 'showInitiativeForm'])->name('public.forms.initiative');
        Route::post('/initiative', [FormController::class, 'storeInitiative'])->name('public.forms.initiative.store');
        
        // Contribution Requests
        Route::get('/contribution-request', [FormController::class, 'showContributionRequestForm'])->name('public.forms.contribution');
        Route::post('/contribution-request', [FormController::class, 'storeContributionRequest'])->name('public.forms.contribution.store');
    });
});

// Settings Routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('settings.profile');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('/settings/profile', [ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('/settings/password', [ProfileController::class, 'editPassword'])->name('settings.password');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Admin Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Filament Admin Panel
// Handled by Filament automatically at /admin
