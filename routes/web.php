<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    InventoryController,
    SupplierController,
    GenreController,
    ConnectionSaleController,
    MoviesController,
    ClassificationController,
    HallLocationController,
    HallCinemaController,
    ShowtimeController,
    SeatTypeController,
    SeatController
};

/*
|--------------------------------------------------------------------------
| Frontend: Cinemagic
|--------------------------------------------------------------------------
*/
Route::prefix('cinemagic')->name('fe.')->group(function () {
    // Main page
    Route::view('/', 'Frontend.cinemagic')->name('cinemagic');

    // Static sections (if you still want separate pages)
    Route::view('/menu',    'Frontend.menu')->name('menu');
    Route::view('/review',  'Frontend.review')->name('review');
    Route::view('/booking', 'Frontend.booking')->name('booking');
    Route::view('/movies',  'Frontend.movies')->name('movies');

    // Auth pages (customer)
    Route::view('/login',    'Frontend.auth.customer.login')->name('login');
    Route::view('/register', 'Frontend.auth.customer.register')->name('register'); // create this view
});

// Optional: redirect legacy paths to Cinemagic versions
Route::redirect('/login', '/cinemagic/login');
Route::redirect('/register', '/cinemagic/register');

/*
|--------------------------------------------------------------------------
| Backend / Admin Routes (view-only)
|--------------------------------------------------------------------------
*/
Route::view('/', 'Backend.Dashboard.index');
Route::view('/admin', 'Backend.Dashboard.index')->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| Resource Controllers
|--------------------------------------------------------------------------
*/
Route::resource('suppliers', SupplierController::class);
Route::resource('inventory', InventoryController::class);
Route::resource('sale', ConnectionSaleController::class);
Route::resource('hall_locations', HallLocationController::class);
Route::resource('hallCinema', HallCinemaController::class);
Route::resource('movies', MoviesController::class);
Route::resource('genre', GenreController::class);
Route::resource('classification', ClassificationController::class);
// Route::resource('showtimes', ShowtimeController::class);
Route::resource('seattypes', SeatTypeController::class);
Route::resource('seats', SeatController::class);

/*
|--------------------------------------------------------------------------
| Reports / Analytics
|--------------------------------------------------------------------------
*/
Route::get('/connection-sales/report', [ConnectionSaleController::class, 'generateReport'])->name('sale.report');
Route::get('/connection-sales/best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');
Route::get('/connection-sales/analytics', [ConnectionSaleController::class, 'analytics'])->name('sale.analytics');
Route::get('/connection-sales/monthly-report', [ConnectionSaleController::class, 'monthlyReport'])->name('sale.monthly-report');
Route::get('/connection-sales/chart-data', [ConnectionSaleController::class, 'chartData'])->name('sale.chart-data');

/*
|--------------------------------------------------------------------------
| Feature routes
|--------------------------------------------------------------------------
*/
Route::get('/movies/search', [MoviesController::class, 'search'])->name('movies.search');

Route::get('/hall-cinema/search', [HallCinemaController::class, 'search'])->name('hallCinema.search');
Route::get('/hall-cinema/analytics', [HallCinemaController::class, 'analytics'])->name('hallCinema.analytics');

Route::get('/hall-locations/search', [HallLocationController::class, 'search'])->name('hall_locations.search');
Route::get('/hall-locations/{id}/details', [HallLocationController::class, 'details'])->name('hall_locations.details');
Route::get('/hall-locations/nearby', [HallLocationController::class, 'nearby'])->name('hall_locations.nearby');
Route::get('/hall-locations/analytics', [HallLocationController::class, 'analytics'])->name('hall_locations.analytics');
Route::get('/hall-locations/cities', [HallLocationController::class, 'cities'])->name('hall_locations.cities');

/*
|--------------------------------------------------------------------------
| Public API (no auth)
|--------------------------------------------------------------------------
*/
Route::prefix('api/locations')->group(function () {
    Route::get('/search', [HallLocationController::class, 'search'])->name('api.locations.search');
    Route::get('/cities', [HallLocationController::class, 'cities'])->name('api.locations.cities');
    Route::get('/nearby', [HallLocationController::class, 'nearby'])->name('api.locations.nearby');
    Route::get('/{id}/details', [HallLocationController::class, 'details'])->name('api.locations.details');
});
