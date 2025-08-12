<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

// Public Dashboard - McKinsey-style transparency page
Route::get('/', function () {
    return view('home');
})->name('home');

// API Routes for dashboard data
Route::prefix('api')->group(function () {
    Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData']);
    Route::get('/real-time-stats', [DashboardController::class, 'getRealTimeStats']);
});

// Admin Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Profile routes (Laravel default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Filament Admin Panel
// Handled by Filament automatically at /admin

require __DIR__.'/auth.php';
