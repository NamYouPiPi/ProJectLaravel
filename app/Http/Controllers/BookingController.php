<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Customer;
use App\Models\Employees;
use App\Models\Movies;
use App\Models\Seats;
use App\Models\Showtime;
use App\Models\showtimes;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view_bookings')->only(['index', 'show']);
        $this->middleware('permission:create_bookings')->only(['create', 'store']);
        $this->middleware('permission:edit_bookings')->only(['edit', 'update']);
        $this->middleware('permission:delete_bookings')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'showtime']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        return view('bookings.index', compact('bookings'))->with('success', 'Bookings retrieved successfully.');
    }

public function paymentCallback(Request $request, Booking $booking)
{
    // Verify payment status with ABA if needed
   $booking->update(['status' => 'paid']);

    // Update all related seats to 'booked'
    foreach ($booking->seats as $seat) {
        $seat->pivot->status = 'booked';
        $seat->pivot->save();
    }    return view('Frontend.Booking.success', compact('booking'));
}

public function paymentCancel(Request $request, Booking $booking)
{
    $booking->update(['status' => 'cancelled']);
    return view('Frontend.Booking.cancel', compact('booking'));
}

    public function payWithABA(Request $request)
    {
        $seatIds = json_decode($request->input('seats'), true);
        // Get seats and calculate total price
        $seats = Seats::whereIn('id', $seatIds)->with('seatType')->get();
        $total = $seats->sum(fn($seat) => $seat->seatType->price);
        // Get authenticated customer
        $customer = Customer::find(auth()->id());
        if (!$customer) {
            return back()->with('error', 'Customer not found.');
        }

        // Create booking
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'showtime_id' => $request->showtime_id,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Prepare pivot data for seats
        $pivotData = [];
        foreach ($seats as $seat) {
            $pivotData[$seat->id] = [
                'price' => $seat->seatType->price,
                'status' => 'reserved',
            ];
        }
        $booking->seats()->attach($pivotData);

        $request_time = now()->format('YmdHis');
        $merchant_id = config('aba.merchant_id');
        $tran_id = (string) $booking->id . date('YmdHis');
        $amount = number_format($total, 2, '.', '');
        $currency = 'USD';

        // Hash string must include amount and currency in the correct order
        $b4hash = $request_time . $merchant_id . $tran_id . $amount . $currency;
        $hash = base64_encode(hash_hmac('sha512', $b4hash, config('aba.api_key'), true));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('aba.api_url'), [
            'req_time' => $request_time,
            'merchant_id' => $merchant_id,
            'tran_id' => $tran_id,
            'amount' => $amount,
            'currency' => $currency,
            'hash' => $hash,
        ]);

        $data = $response->json();
        // dd($data);
    $booking->update(['tran_id' => $tran_id]);
    // Pass QR data to the view
    return view('Frontend.Booking.khqr', [
        'booking' => $booking,
        'qrImage' => $data['qrImage'],
        'abapay_deeplink' => $data['abapay_deeplink'] ?? null,
        'qrString' => $data['qrString'] ?? null,
    ]);
   }



public function createForShowtime($showtimeId)
{
    $showtime = showtimes::with('hall', 'movie')->findOrFail($showtimeId);
    $movie = $showtime->movie;
    $hall = $showtime->hall;
    $seats = Seats::where('hall_id', $hall->id)->get();

    // Get booked seats for this showtime
    $bookedSeats = BookingSeat::whereHas('booking', function($query) use ($showtime) {
        $query->where('showtime_id', $showtime->id)
            ->whereIn('status', ['confirmed', 'pending']);
    })->pluck('seat_id')->toArray();

    // Group seats by row
    $seatRows = $seats->groupBy('seat_row');
    $sortedRows = $seatRows->sortKeysDesc();
    $rowsArray = $sortedRows->keys()->toArray();

    // Prepare seat statuses
    $seatStatuses = [];
    foreach ($seats as $seat) {
        $status = in_array($seat->id, $bookedSeats) ? 'booked' : $seat->status;
        $seatStatuses[$seat->seat_row . '-' . $seat->seat_number] = $status;
    }

 $GroupA = Seats::where('seat_row', 'A')->get();
        $GroupB = Seats::where('seat_row', 'B')->get();
        $GroupC = Seats::where('seat_row', 'C')->get();
        $GroupD = Seats::where('seat_row', 'D')->get();
        $GroupE = Seats::where('seat_row', 'E')->get();
        $GroupF = Seats::where('seat_row', 'F')->get();
        $GroupG = Seats::where('seat_row', 'G')->get();
        $GroupH = Seats::where('seat_row', 'H')->get();
        $GroupI = Seats::where('seat_row', 'I')->get();
        $GroupJ = Seats::where('seat_row', 'J')->get();



    return view('Frontend.Booking.create', [
        'movie' => $movie,
        'showtime' => $showtime,
        'hall' => $hall,
        'seats' => $seats,
        'bookedSeats' => $bookedSeats,
        'rowsArray' => $rowsArray,
        'seatStatuses' => $seatStatuses,
        'GroupA' => $GroupA,
        'GroupB' => $GroupB,
        'GroupC' => $GroupC,
        'GroupD' => $GroupD,
        'GroupE' => $GroupE,
        'GroupF' => $GroupF,
        'GroupG' => $GroupG,
        'GroupH' => $GroupH,
        'GroupI' => $GroupI,
        'GroupJ' => $GroupJ,
    ]);
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $showtimes = showtimes::where('start_time', '>', now())->get();
        // If this method is mistakenly called for frontend, pass empty $seatRows to avoid error
        $seatRows = collect(); // Empty collection to prevent undefined
        return view('bookings.create', compact('customers', 'showtimes'))->with('seatRows', $seatRows);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $movieId)
    {
        // Validate frontend fields
        $validated = $request->validate([
            'seats' => 'required|string', // Comma-separated seat IDs like 'A-1,B-2'
        ]);

        $movie = Movies::findOrFail($movieId);
        $showtime = showtimes::where('movie_id', $movieId)
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->first();

        if (!$showtime) {
            return back()->with('error', 'No upcoming showtime found for this movie.');
        }

        $selectedSeatIds = explode(',', $validated['seats']);
        $seats = collect();

        // Parse seat IDs and find corresponding seats
        foreach ($selectedSeatIds as $seatId) {
            $parts = explode('-', $seatId);
            if (count($parts) === 2) {
                $row = $parts[0];
                $number = $parts[1];
                $seat = Seats::where('hall_id', $showtime->hall_id)
                           ->where('seat_row', $row)
                           ->where('seat_number', $number)
                           ->first();
                if ($seat) {
                    $seats->push($seat);
                }
            }
        }

        if ($seats->isEmpty()) {
            return back()->with('error', 'No valid seats selected.');
        }

        // Check if seats are available
        foreach ($seats as $seat) {
            $isBooked = BookingSeat::where('seat_id', $seat->id)
                                 ->whereHas('booking', function($query) use ($showtime) {
                                     $query->where('showtime_id', $showtime->id)
                                           ->whereIn('status', ['confirmed', 'pending']);
                                 })
                                 ->exists();

            if ($isBooked || $seat->status !== 'available') {
                return back()->with('error', 'Some seats are already booked or not available.');
            }
        }

        // Calculate total (assuming $3.00 per seat)
        $seatPrice = 3.00;
        $totalAmount = count($selectedSeatIds) * $seatPrice;

        // Create booking (assume authenticated user as customer; adjust if needed)
        $customer = auth()->user(); // Or fetch from session
        $booking = Booking::create([
            'customer_id' => $customer->id ?? 1, // Default or adjust
            'showtime_id' => $showtime->id,
            'booking_reference' => 'BK-' . strtoupper(substr(md5(uniqid()), 0, 8)),
            'total_amount' => $totalAmount,
            'booking_fee' => 0, // Adjust if needed
            'discount_amount' => 0,
            'final_amount' => $totalAmount,
            'status' => 'pending',
            'expires_at' => $showtime->end_time,
        ]);

        // Attach seats to booking
        foreach ($seats as $seat) {
            BookingSeat::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat->id,
                'price' => $seatPrice,
                'status' => 'pending'
            ]);
        }

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking->load(['customer', 'showtime']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $customers = Customer::all();
        $showtimes = showtimes::all();

        return view('bookings.edit', compact('booking', 'customers', 'showtimes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'total_amount' => 'required|numeric|min:0',
            'booking_fee' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        // Calculate final amount
        $discount = $validated['discount_amount'] ?? 0;
        $final_amount = $validated['total_amount'] + $validated['booking_fee'] - $discount;

        $booking->update([
            'customer_id' => $validated['customer_id'],
            'showtime_id' => $validated['showtime_id'],
            'total_amount' => $validated['total_amount'],
            'booking_fee' => $validated['booking_fee'],
            'discount_amount' => $discount,
            'final_amount' => $final_amount,
            'status' => $validated['status'],
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        // $booking->delete();
        $booking->status = 'cancelled';
        $booking->save(); // Save the updated status
        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * Get all bookings for a specific customer.
     *
     * @param  int  $customer_id
     * @return \Illuminate\Http\Response
     */
    public function getCustomerBookings($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $bookings = Booking::where('customer_id', $customer_id)
                           ->with(['showtime'])
                           ->latest()
                           ->paginate(10);

        return view('bookings.customer', compact('bookings', 'customer'));
    }

    /**
     * Get all bookings for a specific showtime.
     *
     * @param  int  $showtime_id
     * @return \Illuminate\Http\Response
     */
    public function getShowtimeBookings($showtime_id)
    {
        $showtime = showtimes::with('movie', 'hallCinema')->findOrFail($showtime_id);
        $bookings = Booking::where('showtime_id', $showtime_id)
                           ->with(['customer'])
                           ->latest()
                           ->get();

        return view('bookings.showtime', compact('bookings', 'showtime'));
    }

    /**
     * Confirm a booking
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cannot confirm a cancelled booking.');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking has been confirmed successfully.');
    }

    /**
     * Cancel a booking
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'completed') {
            return back()->with('error', 'Cannot cancel a completed booking.');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        // Update seats status to cancelled
        if ($booking->seats) {
            foreach ($booking->seats as $seat) {
                $seat->update(['status' => 'cancelled']);
            }
        }

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking has been cancelled successfully.');
    }

    /**
     * Mark a booking as expired.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function expireBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can expire.');
        }

        $booking->update([
            'status' => 'cancelled',
            'expires_at' => now()
        ]);

        return back()->with('success', 'Booking marked as expired.');
    }

    /**
     * Generate invoice/receipt for a booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateInvoice($id)
    {
        $booking = Booking::with(['customer', 'employee', 'showtime.movie', 'showtime.hallCinema', 'seats'])
                         ->findOrFail($id);

        $pdf = Pdf::loadView('bookings.invoice', compact('booking'));

        return $pdf->download('Booking_' . $booking->booking_reference . '.pdf');
    }

    /**
     * Get daily booking statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDailyStats(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $bookings = Booking::whereDate('created_at', $date)
                          ->with(['customer', 'showtime.movie'])
                          ->get();

        $stats = [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'total_revenue' => $bookings->where('status', '!=', 'cancelled')->sum('final_amount'),
            'total_booking_fees' => $bookings->where('status', '!=', 'cancelled')->sum('booking_fee'),
            'total_discounts' => $bookings->where('status', '!=', 'cancelled')->sum('discount_amount'),
        ];

        return view('bookings.daily_stats', compact('bookings', 'stats', 'date'));
    }

    /**
     * Get monthly booking statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMonthlyStats(Request $request)
    {
        $year = $request->year ? (int)$request->year : Carbon::now()->year;
        $month = $request->month ? (int)$request->month : Carbon::now()->month;

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])
                          ->with(['customer', 'showtime.movie'])
                          ->get();

        // Group by day
        $dailyStats = [];
        for ($day = 1; $day <= $endDate->day; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $dailyBookings = $bookings->filter(function($booking) use ($date) {
                return $booking->created_at->isSameDay($date);
            });

            $dailyStats[$day] = [
                'date' => $date->format('Y-m-d'),
                'count' => $dailyBookings->count(),
                'revenue' => $dailyBookings->where('status', '!=', 'cancelled')->sum('final_amount'),
            ];
        }

        $monthlyTotals = [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'total_revenue' => $bookings->where('status', '!=', 'cancelled')->sum('final_amount'),
            'total_booking_fees' => $bookings->where('status', '!=', 'cancelled')->sum('booking_fee'),
            'total_discounts' => $bookings->where('status', '!=', 'cancelled')->sum('discount_amount'),
        ];

        return view('bookings.monthly_stats', compact('bookings', 'dailyStats', 'monthlyTotals', 'year', 'month'));
    }
}
