<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicUserController;
use App\Http\Controllers\PublicInitiativeController;
use App\Http\Controllers\PublicPageController;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api/statistics', [App\Http\Controllers\HomeController::class, 'getStatisticsApi'])->name('api.statistics');
Route::get('/api/chart-data', [App\Http\Controllers\HomeController::class, 'getChartData'])->name('api.chart-data');
Route::get('/api/recent-initiatives', [App\Http\Controllers\HomeController::class, 'getRecentInitiatives'])->name('api.recent-initiatives');

// Public Pages Routes
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/', [PublicPageController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicPageController::class, 'show'])->name('show');
});

// Public Initiative Routes
Route::prefix('initiatives')->name('initiatives.')->group(function () {
    Route::get('/', [PublicInitiativeController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicInitiativeController::class, 'show'])->name('show');
    Route::get('/{slug}/apply', [PublicInitiativeController::class, 'apply'])->name('apply');
    Route::post('/{slug}/apply', [PublicInitiativeController::class, 'storeApplication'])->name('store-application');
});

// Public User Application Management
Route::middleware(['auth:public'])->prefix('my-applications')->name('my-applications.')->group(function () {
    Route::get('/', [PublicInitiativeController::class, 'myApplications'])->name('index');
    Route::get('/{id}', [PublicInitiativeController::class, 'showApplication'])->name('show');
});

// Public User Authentication Routes
Route::prefix('auth')->name('public.')->group(function () {
    Route::get('/login', [PublicUserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PublicUserController::class, 'login']);
    Route::post('/logout', [PublicUserController::class, 'logout'])->name('logout');
    Route::get('/register', [PublicUserController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [PublicUserController::class, 'register']);
    
    // Password Reset Routes for Public Users
    Route::get('/forgot-password', [PublicUserController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PublicUserController::class, 'sendPasswordResetLink']);
    Route::get('/reset-password/{token}', [PublicUserController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PublicUserController::class, 'resetPassword'])->name('password.update');
});

// Public User Dashboard
Route::middleware(['auth:public'])->group(function () {
    Route::get('/dashboard', [PublicUserController::class, 'dashboard'])->name('public.dashboard');
    Route::get('/profile', [PublicUserController::class, 'profile'])->name('public.profile');
    Route::put('/profile', [PublicUserController::class, 'updateProfile'])->name('public.profile.update');
});

// Admin Routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// General dashboard route that redirects based on user type
Route::middleware(['auth'])->get('/dashboard', function () {
    if (auth()->guard('public')->check()) {
        return app(\App\Http\Controllers\PublicUserController::class)->dashboard();
    }
    return redirect('/admin/dashboard'); // Redirect to admin dashboard URL
})->name('dashboard');

require __DIR__.'/auth.php';
