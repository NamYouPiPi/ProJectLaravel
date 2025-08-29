<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movies;
use App\Models\Seat;
use App\Models\Seats;
use App\Models\showtimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingSeatController extends Controller
{


     public function payWithABA(Request $request)
    {
        // Validate and get seat IDs
        $seatIds = json_decode($request->input('seats'), true);
        if (!$seatIds || !is_array($seatIds) || count($seatIds) === 0) {
            return back()->with('error', 'No seats selected.');
        }

        // Calculate total price based on seat type
        $seats = Seats::whereIn('id', $seatIds)->with('seatType')->get();
        $total = $seats->sum(fn($seat) => $seat->seatType->price);

        // Create booking (adjust fields as needed)
        $booking = Booking::create([
            'customer_id' => auth()->id(),
            'showtime_id' => $request->showtime_id,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Attach seats to booking
        $booking->seats()->attach($seatIds);

        // Prepare ABA PayWay payload
        $tranId = $booking->id . '-' . time();
        $payload = [
            'tran_id' => $tranId,
            'amount' => $total,
            'currency' => 'USD',
            'return_url' => route('booking.callback', ['booking' => $booking->id]),
            'cancel_url' => route('booking.cancel', ['booking' => $booking->id]),
            'client_ip' => $request->ip(),
            'order' => [
                'items' => $seats->map(fn($seat) => [
                    'name' => 'Seat ' . $seat->seat_number,
                    'quantity' => 1,
                    'price' => $seat->seatType->price,
                ])->values()->toArray(),
            ],
            'merchant_id' => trim(env('ABA_MERCHANT_ID')),
        ];

        // Call ABA PayWay API
        $response = Http::withHeaders([
            'x-api-key' => env('ABA_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('ABA_API_URL'), $payload);
        if (!$response->successful()) {
            dd($response->status(), $response->body(), $payload);
        }
        if ($response->successful() && isset($response['payment_url'])) {
            // Optionally save tran_id to booking for later reference
            $booking->update(['tran_id' => $tranId]);
            // Redirect to ABA payment page
            return redirect($response['payment_url']);
        } else {
            // Handle error
            return back()->with('error', 'Payment gateway error: ' . $response->body());
        }
    }
    /**
     * Display a listing of the booking seats.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = BookingSeat::with(['booking', 'seat']);

        // Filter by booking_id if provided
        if ($request->has('booking_id') && $request->booking_id) {
            $query->where('booking_id', $request->booking_id);
        }

        $bookingSeats = $query->latest()->paginate(20);
        return view('booking_seats.index', compact('bookingSeats'));
    }

    /**
     * Show the form for creating a new booking seat.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bookings = Booking::where('status', '!=', 'cancelled')->get();
        $booking_id = $request->booking_id ?? null;

        $showtime_id = null;
        if ($booking_id) {
            $booking = Booking::findOrFail($booking_id);
            $showtime_id = $booking->showtime_id;
        }

        // Get available seats for the showtime
        $seats = [];
        if ($showtime_id) {
            $showtime = showtimes::findOrFail($showtime_id);
            $bookedSeatIds = BookingSeat::whereHas('booking', function($query) use ($showtime_id) {
                $query->where('showtime_id', $showtime_id)
                      ->where('status', '!=', 'cancelled');
            })->pluck('seat_id')->toArray();

            $seats = Seats::where('hall_cinema_id', $showtime->hall_cinema_id)
                         ->whereNotIn('id', $bookedSeatIds)
                         ->get();
        }

        return view('booking_seats.create', compact('bookings', 'booking_id', 'seats'));
    }




    public function showSeatMap($hallId)
    {
        // Get all seats for the hall, grouped by row and sorted by seat_number
        $seats = Seats::where('hall_id', $hallId)
            ->orderBy('seat_row')
            ->orderBy('seat_number')
            ->get()
            ->groupBy('seat_row');

        return view('Frontend.Booking.create', compact('seats'));
    }
    /**
     * Store a newly created booking seat in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'seat_id' => 'required|exists:seats,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,cancelled',
        ]);

        // Check if the seat is already booked for this showtime
        $booking = Booking::findOrFail($validated['booking_id']);
        $isSeatBooked = BookingSeat::whereHas('booking', function($query) use ($booking) {
            $query->where('showtime_id', $booking->showtime_id)
                  ->where('status', '!=', 'cancelled');
        })->where('seat_id', $validated['seat_id'])->exists();

        if ($isSeatBooked) {
            return back()->withErrors(['seat_id' => 'This seat is already booked for this showtime.'])
                        ->withInput();
        }

        $bookingSeat = BookingSeat::create([
            'booking_id' => $validated['booking_id'],
            'seat_id' => $validated['seat_id'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Update booking total amount
        $totalSeatsAmount = BookingSeat::where('booking_id', $booking->id)
                                      ->where('status', 'active')
                                      ->sum('price');

        $booking->update([
            'total_amount' => $totalSeatsAmount,
            'final_amount' => $totalSeatsAmount + $booking->booking_fee - $booking->discount_amount
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Seat booked successfully.');
    }

    /**
     * Display the specified booking seat.
     *
     * @param  \App\Models\BookingSeat  $bookingSeat
     * @return \Illuminate\Http\Response
     */
    public function show(BookingSeat $bookingSeat)
    {
        $bookingSeat->load(['booking', 'seat']);
        return view('booking_seats.show', compact('bookingSeat'));
    }

    /**
     * Show the form for editing the specified booking seat.
     *
     * @param  \App\Models\BookingSeat  $bookingSeat
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingSeat $bookingSeat)
    {
        $bookings = Booking::where('status', '!=', 'cancelled')->get();

        // Get available seats for the showtime
        $booking = $bookingSeat->booking;
        $showtime_id = $booking->showtime_id;
        $showtime = showtimes::findOrFail($showtime_id);

        $bookedSeatIds = BookingSeat::whereHas('booking', function($query) use ($showtime_id) {
            $query->where('showtime_id', $showtime_id)
                  ->where('status', '!=', 'cancelled');
        })->where('id', '!=', $bookingSeat->id)
          ->pluck('seat_id')->toArray();

        $seats = Seats::where('hall_cinema_id', $showtime->hall_cinema_id)
                     ->whereNotIn('id', $bookedSeatIds)
                     ->orWhere('id', $bookingSeat->seat_id)
                     ->get();

        return view('booking_seats.edit', compact('bookingSeat', 'bookings', 'seats'));
    }

    /**
     * Update the specified booking seat in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingSeat  $bookingSeat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingSeat $bookingSeat)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'seat_id' => 'required|exists:seats,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,cancelled',
        ]);

        // Check if the seat is already booked for this showtime (excluding the current booking seat)
        $booking = Booking::findOrFail($validated['booking_id']);
        $isSeatBooked = BookingSeat::whereHas('booking', function($query) use ($booking) {
            $query->where('showtime_id', $booking->showtime_id)
                  ->where('status', '!=', 'cancelled');
        })->where('seat_id', $validated['seat_id'])
          ->where('id', '!=', $bookingSeat->id)
          ->exists();

        if ($isSeatBooked) {
            return back()->withErrors(['seat_id' => 'This seat is already booked for this showtime.'])
                        ->withInput();
        }

        $bookingSeat->update([
            'booking_id' => $validated['booking_id'],
            'seat_id' => $validated['seat_id'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Update booking total amount
        $totalSeatsAmount = BookingSeat::where('booking_id', $booking->id)
                                      ->where('status', 'active')
                                      ->sum('price');

        $booking->update([
            'total_amount' => $totalSeatsAmount,
            'final_amount' => $totalSeatsAmount + $booking->booking_fee - $booking->discount_amount
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking seat updated successfully.');
    }

    /**
     * Remove the specified booking seat from storage.
     *
     * @param  \App\Models\BookingSeat  $bookingSeat
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingSeat $bookingSeat)
    {
        $booking = $bookingSeat->booking;

        // Instead of deleting, mark as cancelled
        $bookingSeat->update(['status' => 'cancelled']);

        // Update booking total amount
        $totalSeatsAmount = BookingSeat::where('booking_id', $booking->id)
                                      ->where('status', 'active')
                                      ->sum('price');

        $booking->update([
            'total_amount' => $totalSeatsAmount,
            'final_amount' => $totalSeatsAmount + $booking->booking_fee - $booking->discount_amount
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking seat cancelled successfully.');
    }

    /**
     * Get seats for a specific showtime.
     *
     * @param  int  $showtime_id
     * @return \Illuminate\Http\Response
     */
    public function getSeatsForShowtime($showtime_id)
    {
        $showtime = showtimes::with('hallCinema')->findOrFail($showtime_id);

        // Get booked seats
        $bookedSeats = BookingSeat::whereHas('booking', function($query) use ($showtime_id) {
            $query->where('showtime_id', $showtime_id)
                  ->where('status', '!=', 'cancelled');
        })->with('seat')->get();

        // Get all seats for the hall cinema
        $allSeats = Seats::where('hall_cinema_id', $showtime->hall_cinema_id)->get();

        $bookedSeatIds = $bookedSeats->pluck('seat_id')->toArray();

        $availableSeats = $allSeats->filter(function($seat) use ($bookedSeatIds) {
            return !in_array($seat->id, $bookedSeatIds);
        });

        return response()->json([
            'available_seats' => $availableSeats,
            'booked_seats' => $bookedSeats,
            'all_seats' => $allSeats,
            'showtime' => $showtime
        ]);
    }

    /**
     * Book multiple seats at once.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookMultipleSeats(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
            'price' => 'required|numeric|min:0',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);
        $showtime_id = $booking->showtime_id;

        // Check if any seats are already booked
        $bookedSeatIds = BookingSeat::whereHas('booking', function($query) use ($showtime_id) {
            $query->where('showtime_id', $showtime_id)
                  ->where('status', '!=', 'cancelled');
        })->pluck('seat_id')->toArray();

        $alreadyBookedSeats = array_intersect($validated['seat_ids'], $bookedSeatIds);

        if (!empty($alreadyBookedSeats)) {
            return back()->withErrors(['seat_ids' => 'Some selected seats are already booked.'])
                        ->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($validated['seat_ids'] as $seat_id) {
                BookingSeat::create([
                    'booking_id' => $validated['booking_id'],
                    'seat_id' => $seat_id,
                    'price' => $validated['price'],
                    'status' => 'active',
                ]);
            }

            // Update booking total amount
            $totalSeatsAmount = BookingSeat::where('booking_id', $booking->id)
                                          ->where('status', 'active')
                                          ->sum('price');

            $booking->update([
                'total_amount' => $totalSeatsAmount,
                'final_amount' => $totalSeatsAmount + $booking->booking_fee - $booking->discount_amount
            ]);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Multiple seats booked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to book seats: ' . $e->getMessage()])
                        ->withInput();
        }
    }

}

