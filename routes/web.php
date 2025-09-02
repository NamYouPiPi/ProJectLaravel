<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaywayController;
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
    BookingSeatController,
    CarouselController,
    PromotionController
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

/// public route
Route::get('/', [MoviesController::class, 'home'])->name('frontend.home');
Route::post('/booking/pay', [BookingController::class, 'payWithABA'])->name('booking.pay');
Route::get('/booking/callback/{booking}', [BookingController::class, 'paymentCallback'])->name('booking.callback');
Route::get('/booking/cancel/{booking}', [BookingController::class, 'paymentCancel'])->name('booking.cancel');
// google login and  google callback routes
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::resource('carousels' , CarouselController::class);

// end of google login and  google callback routes

Route::get('/theaters', function () {
    return view('Frontend.theaters');
})->name('theaters');

Route::get('/offer', [PromotionController::class, 'Frontend'])->name('offer');
Route::get('/carousel', [CarouselController::class, 'FrontendCarousel'])->name('carousel');
// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
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

// ===== Dashboard =====
Route::middleware(['auth', 'permission:access_dashboard'])->group(function () {
    Route::get('/dashboard', function () {
        return view('Backend.Dashboard.index');
    })->name('dashboard');
    Route::get('/dashboard/chart-data', [App\Http\Controllers\DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
});




// ===== Supplier Management =====
Route::middleware(['auth', 'permission:view_suppliers'])->group(function () {
    Route::resource('suppliers', SupplierController::class);
});

// ===== Inventory Management =====
Route::middleware(['auth', 'permission:view_inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// ===== Sales Management =====
Route::middleware(['auth', 'permission:view_sales'])->group(function () {
    Route::resource('sale', ConnectionSaleController::class);
    Route::post('sale.best-sellers', [ConnectionSaleController::class, 'bestSellers'])->name('sale.best-sellers');
    Route::get('sale.report', [ConnectionSaleController::class, 'report'])->name('sale.report');
});

// ===== Hall Location Management =====
Route::middleware(['auth', 'permission:view_hall_locations'])->group(function () {
    Route::resource('hall_locations', HallLocationController::class);
    Route::get('/hall-locations/search', [HallLocationController::class, 'search'])->name('hall_locations.search');
    Route::get('/hall-locations/{id}/details', [HallLocationController::class, 'details'])->name('hall_locations.details');
    Route::get('/hall-locations/nearby', [HallLocationController::class, 'nearby'])->name('hall_locations.nearby');
    Route::get('/hall-locations/analytics', [HallLocationController::class, 'analytics'])->name('hall_locations.analytics');
    Route::get('/hall-locations/cities', [HallLocationController::class, 'cities'])->name('hall_locations.cities');
});

// ===== Hall Cinema Management =====
Route::middleware(['auth', 'permission:view_hall_cinema'])->group(function () {
    Route::resource('hallCinema', HallCinemaController::class);
    Route::get('/hall-cinema/search', [HallCinemaController::class, 'search'])->name('hallCinema.search');
    Route::get('/hall-cinema/analytics', [HallCinemaController::class, 'analytics'])->name('hallCinema.analytics');
});


Route::middleware(['auth', 'permission:view_dashboard'])->group(function () {
Route::get('/dashboard', function () {
    return view('Backend.Dashboard.index');
})->name('dashboard');
});


// ===== Movies Management =====
Route::middleware(['auth', 'permission:view_movies'])->group(function () {
    Route::resource('movies', MoviesController::class);
});

// ===== Showtimes Management =====
Route::middleware(['auth', 'permission:view_showtimes'])->group(function () {
    Route::resource('showtimes', ShowtimesController::class);
});

// ===== Genre Management =====
Route::middleware(['auth', 'permission:view_genre'])->group(function () {
    Route::resource('genre', GenreController::class);
});

// ===== Seat Types Management =====
Route::middleware(['auth', 'permission:view_seat_types'])->group(function () {
    Route::resource('seatTypes', SeatTypeController::class);
});

// ===== Seats Management =====
Route::middleware(['auth', 'permission:view_seats'])->group(function () {
    Route::resource('seats', SeatsController::class);
});

// ===== Customer Management =====
Route::middleware(['auth', 'permission:view_customers'])->group(function () {
    Route::resource('customer', CustomerController::class);
});

// ===== Employee Management =====
Route::middleware(['auth', 'permission:view_employees'])->group(function () {
    Route::resource('employees', EmployeesController::class);
});

// ===== Booking Management =====
// Public booking route for customers
Route::get('/booking/create/{showtime}', [BookingController::class, 'createForShowtime'])->name('booking.createForShowtime');
Route::get('/booking/create/{movieId}', [BookingController::class, 'createForMovie'])->name('booking.create');
Route::post('/booking/{movieId}', [BookingController::class, 'store'])->name('booking.store');

// Admin booking routes
Route::middleware(['auth', 'permission:view_bookings'])->group(function () {
    Route::resource('bookings', BookingController::class);
    Route::get('/bookings/customer/{customer_id}', [BookingController::class, 'getCustomerBookings'])->name('bookings.customer');
    Route::get('/bookings/showtime/{showtime_id}', [BookingController::class, 'getShowtimeBookings'])->name('bookings.showtime');

    // Booking status management
    Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::post('/bookings/{id}/expire', [BookingController::class, 'expireBooking'])->name('bookings.expire');
});

// Booking reports - requires different permission
Route::middleware(['auth', 'permission:view_booking_reports'])->group(function () {
    Route::get('/bookings/{id}/invoice', [BookingController::class, 'generateInvoice'])->name('bookings.invoice');
    Route::get('/bookings/stats/daily', [BookingController::class, 'getDailyStats'])->name('bookings.stats.daily');
    Route::get('/bookings/stats/monthly', [BookingController::class, 'getMonthlyStats'])->name('bookings.stats.monthly');
});

// ===== Booking Seats Management =====
// Public seat selection route
Route::get('/booking-seat-map/{hallId}', [BookingSeatController::class, 'showSeatMap'])->name('booking-seat.map');
Route::get('/bookingseats/success', function() {
    return view('Frontend.Booking.success');
})->name('bookingseats.success');

// Admin booking seat routes
Route::middleware(['auth', 'permission:view_booking_seats'])->group(function () {
    Route::resource('booking-seats', BookingSeatController::class);
    Route::get('/booking-seats/booking/{booking_id}', [BookingSeatController::class, 'getBookingSeats'])->name('booking-seats.booking');
    Route::get('/booking-seats/showtime/{showtime_id}', [BookingSeatController::class, 'getShowtimeSeats'])->name('booking-seats.showtime');
    Route::post('/booking-seats/block', [BookingSeatController::class, 'blockSeats'])->name('booking-seats.block');
    Route::post('/booking-seats/release', [BookingSeatController::class, 'releaseSeats'])->name('booking-seats.release');
    Route::post('/booking-seats/swap', [BookingSeatController::class, 'swapSeat'])->name('booking-seats.swap');
    Route::put('/booking-seats/{id}/state', [BookingSeatController::class, 'updateSeatState'])->name('booking-seats.state');
    Route::resource('bookingseats', BookingSeatController::class);
});

// ===== Payments Management =====
Route::middleware(['auth', 'permission:view_payments'])->group(function () {
    Route::resource('payments', PaymentController::class);
    Route::post('payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');
    Route::get('/payments/check-status/{transactionId}', [PaymentController::class, 'checkPaymentStatus'])->name('payments.check-status');
});

// Payment callback routes - public
Route::get('/payments/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payments.callback');
Route::get('/payments/callback/success', [PaymentController::class, 'handlePaymentSuccess'])->name('payments.callback.success');
Route::get('/payments/callback/cancel', [PaymentController::class, 'handlePaymentCancel'])->name('payments.callback.cancel');
Route::post('/payments/initiate-aba', [PaymentController::class, 'initiateAbaPayment'])->name('payments.initiate.aba');

// ===== Classification Management =====
Route::middleware(['auth', 'permission:view_classification'])->group(function () {
    Route::resource('classification', ClassificationController::class);
});

// ===== Carousel Management =====
Route::middleware(['auth', 'permission:view_carousels'])->group(function () {
    Route::resource('carousels', CarouselController::class);
});

// ===== Promotion Management =====
Route::middleware(['auth', 'permission:view_promotions'])->group(function () {
    Route::resource('promotions', PromotionController::class);
});

// ===== Superadmin Access =====
Route::middleware(['auth', 'role:superadmin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/system/info', function () {
        return view('Backend.SuperAdmin.system-info');
    })->name('system.info');

    Route::get('/system/logs', function () {
        return view('Backend.SuperAdmin.system-logs');
    })->name('system.logs');

    Route::get('/database/status', function () {
        return view('Backend.SuperAdmin.database-status');
    })->name('database.status');

    Route::get('/users/all', function () {
        return view('Backend.SuperAdmin.users-all');
    })->name('users.all');

    Route::get('/roles/all', function () {
        return view('Backend.SuperAdmin.roles-all');
    })->name('roles.all');
});

// ===== User Management =====
Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});

// ===== Permission Management =====
Route::middleware(['auth', 'permission:manage_permissions'])->group(function () {
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('permissions', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('permissions/role/{role}', [PermissionController::class, 'getRolePermissions'])->name('permissions.role');
    Route::get('permissions/groups', [PermissionController::class, 'getPermissionsByGroup'])->name('permissions.groups');
    Route::resource('permission', PermissionController::class);
});

// ===== Role Management =====
Route::middleware(['auth', 'permission:manage_roles'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])
         ->name('roles.permissions');
});
