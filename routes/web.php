<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Default home page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (generic fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Role-based dashboards — used in AuthenticatedSessionController
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Organisateur Dashboard (Create Event Page)
    Route::get('/organisateur/dashboard',function(){
         return view('organisateur.dashboard');
    })->name('organisateur.dashboard');


    // Participant Dashboard
    Route::get('/participant/dashboard', function () {
        return view('participant.dashboard');
    })->name('participant.dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load auth routes
require __DIR__.'/auth.php';
