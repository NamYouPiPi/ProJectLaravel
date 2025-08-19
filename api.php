<?php

// ===========================================
// API CONTROLLERS
// ===========================================

// app/Http/Controllers/Api/AuthController.php
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $staff = Staff::where('email', $validated['email'])->first();

        if (!$staff || !Hash::check($validated['password'], $staff->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$staff->is_active) {
            return response()->json(['message' => 'Account deactivated'], 403);
        }

        $token = $staff->createToken('cinema-api')->plainTextToken;

        return response()->json([
            'staff' => $staff->load('role.permissions'),
            'token' => $token,
            'permissions' => $staff->role->permissions->pluck('name')
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

// app/Http/Controllers/Api/MovieController.php
class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::with('Showtime.theater')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                           ->orWhere('genre', 'like', "%{$search}%");
            })
            ->when($request->active, function ($query) {
                return $query->active();
            })
            ->paginate(15);

        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'rating' => 'nullable|string|max:10',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'language' => 'nullable|string|max:50',
            'base_price' => 'required|numeric|min:0',
            'poster_url' => 'nullable|url|max:500',
            'trailer_url' => 'nullable|url|max:500',
        ]);

        $movie = Movie::create($validated);

        return response()->json($movie, 201);
    }

    public function show(Movie $movie)
    {
        return response()->json($movie->load('Showtime.theater'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'rating' => 'nullable|string|max:10',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'language' => 'nullable|string|max:50',
            'base_price' => 'required|numeric|min:0',
            'poster_url' => 'nullable|url|max:500',
            'trailer_url' => 'nullable|url|max:500',
            'is_active' => 'boolean'
        ]);

        $movie->update($validated);

        return response()->json($movie);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }
}

// app/Http/Controllers/Api/BookingController.php
class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'showtime_id' => 'required|exists:Showtime,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'payment_method' => 'required|in:Cash,Credit Card,Debit Card,Online,Mobile Payment',
            'special_requests' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $showtime = Showtime::with('theater', 'movie')->findOrFail($validated['showtime_id']);
            $seats = Seat::whereIn('id', $validated['seats'])->get();

            // Check availability
            if ($showtime->available_seats < count($validated['seats'])) {
                throw new Exception('Not enough seats available');
            }

            // Calculate total
            $subtotal = $seats->sum(function ($seat) use ($showtime) {
                return $showtime->ticket_price * $seat->price_multiplier;
            });

            $taxAmount = $subtotal * 0.1;
            $totalAmount = $subtotal + $taxAmount;

            // Create booking
            $booking = Booking::create([
                'customer_id' => $validated['customer_id'],
                'showtime_id' => $validated['showtime_id'],
                'staff_id' => auth()->id(),
                'total_seats' => count($validated['seats']),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'booking_status' => 'Confirmed',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'Completed',
                'booking_source' => 'Counter',
                'special_requests' => $validated['special_requests']
            ]);

            // Create booking seats
            foreach ($seats as $seat) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat->id,
                    'seat_price' => $showtime->ticket_price * $seat->price_multiplier
                ]);
            }

            // Update available seats
            $showtime->decrement('available_seats', count($validated['seats']));

            DB::commit();

            return response()->json([
                'booking' => $booking->load('customer', 'showtime.movie', 'bookingSeats.seat'),
                'message' => 'Booking created successfully'
            ], 201);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Booking $booking)
    {
        return response()->json(
            $booking->load('customer', 'showtime.movie', 'showtime.theater', 'bookingSeats.seat')
        );
    }

    public function cancel(Booking $booking)
    {
        if ($booking->booking_status === 'Cancelled') {
            return response()->json(['error' => 'Booking already cancelled'], 400);
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'booking_status' => 'Cancelled',
                'payment_status' => 'Refunded'
            ]);

            $booking->showtime->increment('available_seats', $booking->total_seats);
        });

        return response()->json(['message' => 'Booking cancelled successfully']);
    }
}

// ===========================================
// SEEDERS
// ===========================================

// database/seeders/RolePermissionSeeder.php
class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            // Movies
            ['name' => 'movies.create', 'category' => 'Movies'],
            ['name' => 'movies.read', 'category' => 'Movies'],
            ['name' => 'movies.update', 'category' => 'Movies'],
            ['name' => 'movies.delete', 'category' => 'Movies'],

            // Theaters
            ['name' => 'theaters.create', 'category' => 'Theaters'],
            ['name' => 'theaters.read', 'category' => 'Theaters'],
            ['name' => 'theaters.update', 'category' => 'Theaters'],
            ['name' => 'theaters.delete', 'category' => 'Theaters'],

            // Showtimes
            ['name' => 'Showtime.create', 'category' => 'Showtimes'],
            ['name' => 'Showtime.read', 'category' => 'Showtimes'],
            ['name' => 'Showtime.update', 'category' => 'Showtimes'],
            ['name' => 'Showtime.delete', 'category' => 'Showtimes'],

            // Bookings
            ['name' => 'bookings.create', 'category' => 'Bookings'],
            ['name' => 'bookings.read', 'category' => 'Bookings'],
            ['name' => 'bookings.update', 'category' => 'Bookings'],
            ['name' => 'bookings.cancel', 'category' => 'Bookings'],
            ['name' => 'bookings.refund', 'category' => 'Bookings'],

            // Customers
            ['name' => 'customers.create', 'category' => 'Customers'],
            ['name' => 'customers.read', 'category' => 'Customers'],
            ['name' => 'customers.update', 'category' => 'Customers'],
            ['name' => 'customers.delete', 'category' => 'Customers'],

            // Staff
            ['name' => 'staff.create', 'category' => 'Staff'],
            ['name' => 'staff.read', 'category' => 'Staff'],
            ['name' => 'staff.update', 'category' => 'Staff'],
            ['name' => 'staff.delete', 'category' => 'Staff'],

            // Reports
            ['name' => 'reports.sales', 'category' => 'Reports'],
            ['name' => 'reports.financial', 'category' => 'Reports'],
            ['name' => 'reports.customer', 'category' => 'Reports'],

            // System
            ['name' => 'system.backup', 'category' => 'System'],
            ['name' => 'system.settings', 'category' => 'System'],
            ['name' => 'system.audit', 'category' => 'System'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create Roles
        $roles = [
            ['name' => 'Super Admin', 'description' => 'Full system access'],
            ['name' => 'Manager', 'description' => 'Cinema operations management'],
            ['name' => 'Cashier', 'description' => 'Ticket sales and customer service'],
            ['name' => 'Maintenance', 'description' => 'System maintenance'],
            ['name' => 'Accountant', 'description' => 'Financial reports'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Assign permissions to roles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->permissions()->attach(Permission::all());

        $manager = Role::where('name', 'Manager')->first();
        $managerPermissions = Permission::whereIn('name', [
            'movies.create', 'movies.read', 'movies.update',
            'theaters.read', 'theaters.update',
            'Showtime.create', 'Showtime.read', 'Showtime.update', 'Showtime.delete',
            'bookings.read', 'bookings.update', 'bookings.cancel', 'bookings.refund',
            'customers.read', 'customers.update',
            'staff.read', 'staff.update',
            'reports.sales', 'reports.financial', 'reports.customer'
        ])->get();
        $manager->permissions()->attach($managerPermissions);

        $cashier = Role::where('name', 'Cashier')->first();
        $cashierPermissions = Permission::whereIn('name', [
            'movies.read', 'theaters.read', 'Showtime.read',
            'bookings.create', 'bookings.read', 'bookings.update', 'bookings.cancel',
            'customers.create', 'customers.read', 'customers.update'
        ])->get();
        $cashier->permissions()->attach($cashierPermissions);
    }
}

// database/seeders/CinemaSeeder.php
class CinemaSeeder extends Seeder
{
    public function run()
    {
        // Create sample theaters
        $theaters = [
            ['name' => 'Theater 1', 'capacity' => 100, 'type' => 'Standard'],
            ['name' => 'Theater 2', 'capacity' => 150, 'type' => 'Premium'],
            ['name' => 'IMAX Theater', 'capacity' => 200, 'type' => 'IMAX'],
            ['name' => 'VIP Theater', 'capacity' => 50, 'type' => 'VIP'],
        ];

        foreach ($theaters as $theater) {
            Theater::create($theater);
        }

        // Create seats for each theater
        $theaters = Theater::all();
        foreach ($theaters as $theater) {
            $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
            $seatsPerRow = $theater->capacity / count($rows);

            foreach ($rows as $row) {
                for ($i = 1; $i <= $seatsPerRow; $i++) {
                    Seat::create([
                        'theater_id' => $theater->id,
                        'row_letter' => $row,
                        'seat_number' => $i,
                        'seat_type' => $theater->type === 'VIP' ? 'VIP' : 'Regular',
                        'price_multiplier' => $theater->type === 'VIP' ? 1.5 : 1.0,
                    ]);
                }
            }
        }

        // Create sample movies
        $movies = [
            [
                'title' => 'Avatar: The Way of Water',
                'genre' => 'Action/Adventure',
                'duration_minutes' => 192,
                'rating' => 'PG-13',
                'director' => 'James Cameron',
                'description' => 'Jake Sully and Neytiri have formed a family and are doing everything to stay together.',
                'release_date' => '2022-12-16',
                'base_price' => 12.50,
                'is_active' => true,
            ],
            [
                'title' => 'Top Gun: Maverick',
                'genre' => 'Action/Drama',
                'duration_minutes' => 131,
                'rating' => 'PG-13',
                'director' => 'Joseph Kosinski',
                'description' => 'After thirty years, Maverick is still pushing the envelope as a top naval aviator.',
                'release_date' => '2022-05-27',
                'base_price' => 11.00,
                'is_active' => true,
            ],
            [
                'title' => 'Spider-Man: No Way Home',
                'genre' => 'Action/Adventure',
                'duration_minutes' => 148,
                'rating' => 'PG-13',
                'director' => 'Jon Watts',
                'description' => 'Spider-Man seeks help from Doctor Strange to forget his revealed identity.',
                'release_date' => '2021-12-17',
                'base_price' => 13.00,
                'is_active' => true,
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }

        // Create sample staff
        $cashierRole = Role::where('name', 'Cashier')->first();
        $managerRole = Role::where('name', 'Manager')->first();

        Staff::create([
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@cinema.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
            'department' => 'Operations',
            'hire_date' => '2023-01-15',
        ]);

        Staff::create([
            'employee_id' => 'EMP002',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@cinema.com',
            'password' => Hash::make('password'),
            'role_id' => $cashierRole->id,
            'department' => 'Sales',
            'hire_date' => '2023-03-20',
        ]);

        // Create sample customers
        Customer::create([
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'alice.johnson@email.com',
            'phone' => '555-0123',
            'membership_type' => 'Gold',
            'loyalty_points' => 150,
        ]);

        Customer::create([
            'first_name' => 'Bob',
            'last_name' => 'Wilson',
            'email' => 'bob.wilson@email.com',
            'phone' => '555-0456',
            'membership_type' => 'Silver',
            'loyalty_points' => 75,
        ]);

        // Create sample concessions
        $concessions = [
            ['item_name' => 'Small Popcorn', 'category' => 'Snacks', 'price' => 5.50, 'stock_quantity' => 100],
            ['item_name' => 'Large Popcorn', 'category' => 'Snacks', 'price' => 8.50, 'stock_quantity' => 80],
            ['item_name' => 'Soft Drink (Medium)', 'category' => 'Beverages', 'price' => 4.50, 'stock_quantity' => 120],
            ['item_name' => 'Soft Drink (Large)', 'category' => 'Beverages', 'price' => 6.50, 'stock_quantity' => 100],
            ['item_name' => 'Candy Bar', 'category' => 'Snacks', 'price' => 3.50, 'stock_quantity' => 200],
            ['item_name' => 'Nachos', 'category' => 'Snacks', 'price' => 7.50, 'stock_quantity' => 50],
            ['item_name' => 'Combo Deal', 'category' => 'Combo', 'price' => 15.00, 'stock_quantity' => 75],
        ];

        foreach ($concessions as $concession) {
            Concession::create($concession);
        }
    }
}

// database/seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            CinemaSeeder::class,
        ]);
    }
}

// ===========================================
// API ROUTES
// ===========================================

// routes/api.php
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Movies API
    Route::middleware('permission:movies.read')->group(function () {
        Route::get('/movies', [Api\MovieController::class, 'index']);
        Route::get('/movies/{movie}', [Api\MovieController::class, 'show']);
    });

    Route::middleware('permission:movies.create')->group(function () {
        Route::post('/movies', [Api\MovieController::class, 'store']);
    });

    Route::middleware('permission:movies.update')->group(function () {
        Route::put('/movies/{movie}', [Api\MovieController::class, 'update']);
    });

    Route::middleware('permission:movies.delete')->group(function () {
        Route::delete('/movies/{movie}', [Api\MovieController::class, 'destroy']);
    });

    // Theaters API
    Route::middleware('permission:theaters.read')->group(function () {
        Route::get('/theaters', [Api\TheaterController::class, 'index']);
        Route::get('/theaters/{theater}', [Api\TheaterController::class, 'show']);
    });

    // Showtimes API
    Route::middleware('permission:Showtime.read')->group(function () {
        Route::get('/Showtime', [Api\ShowtimeController::class, 'index']);
        Route::get('/Showtime/{showtime}', [Api\ShowtimeController::class, 'show']);
    });

    // Bookings API
    Route::middleware('permission:bookings.create')->group(function () {
        Route::post('/bookings', [Api\BookingController::class, 'store']);
    });

    Route::middleware('permission:bookings.read')->group(function () {
        Route::get('/bookings', [Api\BookingController::class, 'index']);
        Route::get('/bookings/{booking}', [Api\BookingController::class, 'show']);
    });

    Route::middleware('permission:bookings.cancel')->group(function () {
        Route::post('/bookings/{booking}/cancel', [Api\BookingController::class, 'cancel']);
    });

    // Customers API
    Route::middleware('permission:customers.read')->group(function () {
        Route::get('/customers', [Api\CustomerController::class, 'index']);
        Route::get('/customers/{customer}', [Api\CustomerController::class, 'show']);
    });

    Route::middleware('permission:customers.create')->group(function () {
        Route::post('/customers', [Api\CustomerController::class, 'store']);
    });
});

// ===========================================
// BLADE TEMPLATES
// ===========================================
