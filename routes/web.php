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
Route::resource('/suppliers', SupplierController::class);
Route::resource('/inventory',InventoryController::class );
Route::resource('/sale'  , ConnectionSaleController::class);

Route::resource('/hall_locations', HallLocationController::class);
Route::resource('/hall_cinema', HallCinemaController::class);


Route::get('/connection-sales/report', [ConnectionSaleController::class, 'generateReport'])->name('sale.report');
Route::get('/connection-sales/best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');

Route::resource('/genre' ,GenreController::class);

Route::resource('/movies' , MoviesController::class);
Route::get('/movies/search', [MoviesController::class, 'search'])->name('movies.search');




Route::resource('/classification' , ClassificationController::class);





