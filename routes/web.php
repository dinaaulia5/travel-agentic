<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AlternativeFlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlightDelaySimulationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', [LandingPageController::class, 'index'])->name('landingpage.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-bookings', [BookingController::class, 'index'])->name('my-bookings.index');
    // Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('my-bookings.show');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])
        ->name('my-bookings.show');

    Route::get('/flights/search', [LandingPageController::class, 'search'])->name('flights.search');
    Route::get('/flights/{flight}/passenger', [LandingPageController::class, 'passenger'])->name('flights.passenger');
    Route::post('/flights/review', [LandingPageController::class, 'review'])->name('flights.review');
    Route::post('/flights/payment', [LandingPageController::class, 'payment'])
        ->name('flights.payment');

    Route::post('/flights/payment/process', [LandingPageController::class, 'processPayment'])
        ->name('flights.payment.process');

    Route::get('/flights/success/{booking}', [LandingPageController::class, 'success'])
        ->name('flights.success');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('airports', AirportController::class);
    Route::resource('airlines', AirlineController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('alternatives', AlternativeFlightController::class);
    Route::get('agent-logs', [AgentController::class, 'agentLogs'])->name('agent-logs.index');
    Route::get('agent-recommendations', [AgentController::class, 'agentRecommendations'])->name('agent-recommendations.index');
    Route::post('/flights/{flight}/simulate-delay', [FlightDelaySimulationController::class, 'simulate'])
        ->name('flights.simulate-delay');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
