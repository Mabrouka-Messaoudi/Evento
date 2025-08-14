<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AvisController;
use App\Models\Event;
use Carbon\Carbon;
use App\Models\Reservation;
// Default home page
Route::get('/', [EventController::class, 'home'])->name('home');

// Dashboard (generic fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Role-based dashboards — used in AuthenticatedSessionController
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/admin/categories', [AdminController::class, 'store'])->name('admin.categories.store');
    Route::delete('/admin/category/{category}', [AdminController::class, 'destroyCategories'])->name('admin.categories.destroy');
    Route::put('/admin/categories/{category}', [AdminController::class, 'update'])->name('admin.categories.update');
    Route::get('/categories/{category}/edit', [AdminController::class, 'edit'])->name('admin.categories.edit');
    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('organisateur.events.edit');
    Route::put('/organisateur/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('organisateur.events.destroy');
    Route::put('/organisateur/reservations/{event}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::get('/organisateur/events/creer', [EventController::class, 'createEvent'])
    ->name('organisateur.events.creer');

    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');

    Route::get('/organisateur/reservations', [ReservationController::class, 'index'])
    ->middleware('auth')
    ->name('organisateur.reservations.gestion');

    Route::get('/participant/dashboard', function () {
         $events = Event::all();
        return view('participant.dashboard', ['events' => $events]);
    })->name('participant.dashboard');
Route::get('/events/{id}/{viewType?}', [EventController::class, 'show'])
    ->name('events.show')
    ->where('viewType', 'participant|organisateur')
    ->defaults('viewType', 'participant');
   Route::post('/reservations/{event}', [ReservationController::class, 'store'])->name('reservations.store');
   Route::patch('/reservations/{id}', [ReservationController::class, 'update'])->name('reservation.update');

    // Participant Dashboard


    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/organisateur/dashboard', [EventController::class, 'index'])->name('organisateur.dashboard');
    Route::post('/admin/events', [EventController::class, 'store'])->name('organisateur.events.store');

});
Route::prefix('admin')->name('admin.')->group(function () {

Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

     Route::get('/about',function(){
              return view('home.nav-about');
     });
     Route::get('/evenements', function() {
    $today = Carbon::now();

    $events = Event::where('date_debut', '>=', $today)->get();
    return view('home.nav-events', ['events' => $events]);
})->name('home.nav-events');
Route::get('/participant/dashboard', [EventController::class, 'events'])->name('participant.dashboard');
Route::post('/evenements/{id}/avis', [AvisController::class, 'store'])->name('avis.store');

    // Organisateur Dashboard (Create Event Page)
    // Route::get('/organisateur/dashboard',function(){
    //     $events = Event::all();
    //     $reservations=Reservation::all();
    //      return view('organisateur.dashboard', ['events' => $events,'reservations' => $reservations]);
    // })->name('organisateur.dashboard');

Route::middleware('auth')->get('/mes-reservations', [ReservationController::class, 'historique'])->name('participant.reservations.historique');

Route::middleware('auth')->delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/participant/notifications', [NotificationController::class, 'index'])->name('participant.notifications.index');
});

// Load auth routes
require __DIR__.'/auth.php';
