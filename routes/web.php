<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
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
    ShowtimesController ,
    GoogleController,
    EmployeesController,
    RoleController,
    PermissionController,
    UserController,
    BookingController,
    BookingSeatController

};

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
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
















// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('Frontend.home');
})->name('home');

// Route::get('/booking/{movie}', [MoviesController::class, 'bookingCreate'])->name('booking.create');



// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');






// google login and  google callback routes
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('google/callback', [GoogleController::class, 'handleGoogleCallback']);
// end of google login and  google callback routes


Route::get('/dashboard' , function (){return  view('Backend.Dashboard.index');})->name('dashboard');
Route::resource('suppliers', SupplierController::class);
Route::resource('inventory',InventoryController::class );
Route::resource('sale'  , ConnectionSaleController::class);
Route::post('sale.best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');
Route::get('sale.report', [ConnectionSaleController::class, 'report'])->name('sale.report');


Route::get('/', [MoviesController::class, 'home'])->name('frontend.home');
Route::post('/booking/pay', [BookingController::class, 'payWithABA'])->name('booking.pay');
Route::get('/booking/callback/{booking}', [BookingController::class, 'paymentCallback'])->name('booking.callback');
Route::get('/booking/cancel/{booking}', [BookingController::class, 'paymentCancel'])->name('booking.cancel');


Route::resource('hall_locations', HallLocationController::class);
Route::resource('hallCinema', HallCinemaController::class);
Route::resource('movies' , MoviesController::class);
Route::get('/movies/search', [MoviesController::class, 'search'])->name('movies.search');

Route::resource('showtimes', ShowtimesController::class);
Route::resource('genre' ,GenreController::class);
Route::resource('seatTypes', SeatTypeController::class);
Route::resource('seats', SeatsController::class);
Route::resource('customer' , CustomerController::class);
Route::resource('employees', EmployeesController::class);
Route::resource('bookings', BookingController::class);
Route::get('/booking/create/{showtime}', [BookingController::class, 'createForShowtime'])->name('booking.createForShowtime');


Route::resource('booking-seats', BookingSeatController::class);
Route::resource('payments', PaymentController::class);
Route::resource('classification' , ClassificationController::class);



// Permission Management Routes
   Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('permissions', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('permissions/role/{role}', [PermissionController::class, 'getRolePermissions'])->name('permissions.role');
    Route::get('permissions/groups', [PermissionController::class, 'getPermissionsByGroup'])->name('permissions.groups');
Route::resource('users', UserController::class);



// role
   Route::resource('roles', RoleController::class);
    Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])
         ->name('roles.permissions');




// Booking Customer & Showtime Routes
Route::get('/bookings/customer/{customer_id}', [BookingController::class, 'getCustomerBookings'])->name('bookings.customer');
Route::get('/bookings/showtime/{showtime_id}', [BookingController::class, 'getShowtimeBookings'])->name('bookings.showtime');

// Booking Status Management Routes
Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirmBooking'])->name('bookings.confirm');
Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
Route::post('/bookings/{id}/expire', [BookingController::class, 'expireBooking'])->name('bookings.expire');

// Booking Documents & Reports Routes
Route::get('/bookings/{id}/invoice', [BookingController::class, 'generateInvoice'])->name('bookings.invoice');
Route::get('/bookings/stats/daily', [BookingController::class, 'getDailyStats'])->name('bookings.stats.daily');
Route::get('/bookings/stats/monthly', [BookingController::class, 'getMonthlyStats'])->name('bookings.stats.monthly');

// Booking Seats Routes
Route::get('/booking-seats/booking/{booking_id}', [BookingSeatController::class, 'getBookingSeats'])->name('booking-seats.booking');
Route::get('/booking-seats/showtime/{showtime_id}', [BookingSeatController::class, 'getShowtimeSeats'])->name('booking-seats.showtime');
Route::post('/booking-seats/block', [BookingSeatController::class, 'blockSeats'])->name('booking-seats.block');
Route::post('/booking-seats/release', [BookingSeatController::class, 'releaseSeats'])->name('booking-seats.release');
Route::post('/booking-seats/swap', [BookingSeatController::class, 'swapSeat'])->name('booking-seats.swap');
Route::put('/booking-seats/{id}/state', [BookingSeatController::class, 'updateSeatState'])->name('booking-seats.state');

Route::resource('bookingseats', BookingSeatController::class);


// ABA PayWay Payment Routes - Remove duplicates and ensure all needed routes are defined
Route::post('/payments/initiate-aba', [PaymentController::class, 'initiateAbaPayment'])->name('payments.initiate.aba');
Route::get('/payments/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payments.callback');
Route::get('/payments/callback/success', [PaymentController::class, 'handlePaymentSuccess'])->name('payments.callback.success');
Route::get('/payments/callback/cancel', [PaymentController::class, 'handlePaymentCancel'])->name('payments.callback.cancel');
Route::get('/payments/check-status/{transactionId}', [PaymentController::class, 'checkPaymentStatus'])->name('payments.check-status');
Route::post('payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');





// route for search movies

// Hall Cinema search and filter routes
Route::get('/hall-cinema/search', [HallCinemaController::class, 'search'])->name('hallCinema.search');
Route::get('/hall-cinema/analytics', [HallCinemaController::class, 'analytics'])->name('hallCinema.analytics');

// Hall Location routes for customers and management
Route::get('/hall-locations/search', [HallLocationController::class, 'search'])->name('hall_locations.search');
Route::get('/hall-locations/{id}/details', [HallLocationController::class, 'details'])->name('hall_locations.details');
Route::get('/hall-locations/nearby', [HallLocationController::class, 'nearby'])->name('hall_locations.nearby');
Route::get('/hall-locations/analytics', [HallLocationController::class, 'analytics'])->name('hall_locations.analytics');
Route::get('/hall-locations/cities', [HallLocationController::class, 'cities'])->name('hall_locations.cities');






// Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart-data', [App\Http\Controllers\DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
Route::get('/payments/callback/success', [PaymentController::class, 'handlePaymentSuccess'])->name('payments.callback.success');
Route::get('/payments/callback/cancel', [PaymentController::class, 'handlePaymentCancel'])->name('payments.callback.cancel');
Route::get('/payments/check-status/{transactionId}', [PaymentController::class, 'checkPaymentStatus'])->name('payments.check-status');

// Booking routes
Route::get('/booking/create/{movieId}', [BookingController::class, 'createForMovie'])->name('booking.create');
Route::post('/booking/{movieId}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking-seat-map/{hallId}', [BookingSeatController::class, 'showSeatMap'])->name('booking-seat.map');

Route::post('/frontend/booking/payment', function (\Illuminate\Http\Request $request) {
    $total = $request->input('total', '$0.00');
    return view('Frontend.Booking.payment', ['total' => $total])->render();
})->name('frontend.booking.payment');

Route::get('/bookingseats/success', function() {
    return view('Frontend.Booking.success');
})->name('bookingseats.success');
