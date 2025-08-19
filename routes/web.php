<?php
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    InventoryController,
    SupplierController,
    GenreController,

    ConnectionSaleController,
    MoviesController,
    ClassificationController,
    HallLocationController
    ,HallCinemaController
    ,ShowtimesController
};



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//add route
Route::get('/', function () {return view('Backend.Dashboard.index');});
Route::resource('suppliers', SupplierController::class);
Route::resource('inventory',InventoryController::class );
Route::resource('sale'  , ConnectionSaleController::class);
Route::resource('hall_locations', HallLocationController::class);
Route::resource('hallCinema', HallCinemaController::class);
Route::resource('movies' , MoviesController::class);
Route::resource('Showtime', ShowtimesController::class);



Route::get('/connection-sales/report', [ConnectionSaleController::class, 'generateReport'])->name('sale.report');
Route::get('/connection-sales/best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');
Route::get('/connection-sales/analytics', [ConnectionSaleController::class, 'analytics'])->name('sale.analytics');
Route::get('/connection-sales/monthly-report', [ConnectionSaleController::class, 'monthlyReport'])->name('sale.monthly-report');
Route::get('/connection-sales/chart-data', [ConnectionSaleController::class, 'chartData'])->name('sale.chart-data');

Route::resource('genre' ,GenreController::class);

Route::get('/movies/search', [MoviesController::class, 'search'])->name('movies.search');

// Hall Cinema search and filter routes
Route::get('/hall-cinema/search', [HallCinemaController::class, 'search'])->name('hallCinema.search');
Route::get('/hall-cinema/analytics', [HallCinemaController::class, 'analytics'])->name('hallCinema.analytics');

// Hall Location routes for customers and management
Route::get('/hall-locations/search', [HallLocationController::class, 'search'])->name('hall_locations.search');
Route::get('/hall-locations/{id}/details', [HallLocationController::class, 'details'])->name('hall_locations.details');
Route::get('/hall-locations/nearby', [HallLocationController::class, 'nearby'])->name('hall_locations.nearby');
Route::get('/hall-locations/analytics', [HallLocationController::class, 'analytics'])->name('hall_locations.analytics');
Route::get('/hall-locations/cities', [HallLocationController::class, 'cities'])->name('hall_locations.cities');

// Public API routes for customers (no authentication required)
Route::prefix('api/locations')->group(function () {
    Route::get('/search', [HallLocationController::class, 'search'])->name('api.locations.search');
    Route::get('/cities', [HallLocationController::class, 'cities'])->name('api.locations.cities');
    Route::get('/nearby', [HallLocationController::class, 'nearby'])->name('api.locations.nearby');
    Route::get('/{id}/details', [HallLocationController::class, 'details'])->name('api.locations.details');
});


Route::resource('classification' , ClassificationController::class);






