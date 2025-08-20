<?php
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{InventoryController,
    SeatsController,
    SeatTypeController,
    SupplierController,
    GenreController,
    ConnectionSaleController,
    MoviesController,
    ClassificationController,
    HallLocationController,
    HallCinemaController,
    ShowtimesController};
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
// use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GoogleController;



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

// Authentication Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Dashboard Route
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Redirect home to dashboard for authenticated users
// Route::get('/', function () {
//     if (auth()->check()) {
//         return redirect()->route('dashboard');
//     }
//     return view('welcome');
// });








// google login and  google callback routes
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('google/callback', [GoogleController::class, 'handleGoogleCallback']);
// end of google login and  google callback routes


// Route::middleware(['auth'])->group(function () {
//     Route::resource('suppliers', SupplierController::class);
//     Route::resource('inventory',InventoryController::class );
//     Route::resource('sale'  , ConnectionSaleController::class);
//     Route::resource('hall_locations', HallLocationController::class);
//     Route::resource('hallCinema', HallCinemaController::class);
//     Route::resource('movies' , MoviesController::class);
//     Route::resource('Showtime', ShowtimesController::class);
//     Route::resource('genre' ,GenreController::class);
//     Route::resource('seatTypes', SeatTypeController::class);
//     Route::resource('seats', SeatsController::class);
// });




Route::get('/dashboard' , function (){return  view('Backend.Dashboard.index');})->name('dashboard');
Route::resource('suppliers', SupplierController::class);
Route::resource('inventory',InventoryController::class );
Route::resource('sale'  , ConnectionSaleController::class);
Route::resource('hall_locations', HallLocationController::class);
Route::resource('hallCinema', HallCinemaController::class);
Route::resource('movies' , MoviesController::class);
Route::resource('Showtime', ShowtimesController::class);
Route::resource('genre' ,GenreController::class);
Route::resource('seatTypes', SeatTypeController::class);
Route::resource('seats', SeatsController::class);


//route for connection sales
Route::get('/connection-sales/report', [ConnectionSaleController::class, 'generateReport'])->name('sale.report');
Route::get('/connection-sales/best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');
Route::get('/connection-sales/analytics', [ConnectionSaleController::class, 'analytics'])->name('sale.analytics');
Route::get('/connection-sales/monthly-report', [ConnectionSaleController::class, 'monthlyReport'])->name('sale.monthly-report');
Route::get('/connection-sales/chart-data', [ConnectionSaleController::class, 'chartData'])->name('sale.chart-data');

// route for search movies
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





// Admin routes protected by role middleware
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function() {
    Route::get('/', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Role management routes
    Route::resource('roles', RoleController::class);

    // User management with role assignment
    Route::resource('users', UserController::class);
    Route::post('users/{user}/roles', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('users/{user}/roles', [UserController::class, 'removeRole'])->name('users.remove-role');

    // Permission management routes
    Route::resource('permissions', PermissionController::class);
});

// Routes for managers
Route::group(['prefix' => 'manager', 'middleware' => ['auth', 'role:admin|manager']], function() {
    Route::get('/', function() {
        return view('manager.dashboard');
    })->name('manager.dashboard');

    // Movie management routes
    // ...
});

// Routes accessible to staff
Route::group(['middleware' => ['auth', 'permission:manage bookings']], function() {
    // Booking management routes
    // ...
});

// My Permissions page
Route::get('/my-permissions', function() {
    $user = auth()->user();

    if (!$user) {
        return redirect('/login');
    }

    return view('auth.my-permissions', compact('user'));
})->middleware('auth');



// Test routes for checking permissions
Route::get('/permission-test', function () {
    return view('permission-test');
})->name('permission.test');

// Route protected with permission middleware - only users with 'manage movies' permission can access
Route::get('/permission-test/protected', function () {
    return view('permission-test-protected');
})->middleware('permission:manage movies')->name('permission.test.protected');

// Route protected with role middleware - only admins can access
Route::get('/permission-test/admin-only', function () {
    return view('permission-test-admin');
})->middleware('role:admin')->name('permission.test.admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
