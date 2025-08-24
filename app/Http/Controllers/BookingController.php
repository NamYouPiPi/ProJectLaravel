<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Employees;
use App\Models\Movies;
use App\Models\Showtime;
use App\Models\showtimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $showtimes = showtimes::where('start_time', '>', now())->get();
        return view('bookings.create', compact('customers', 'employees', 'showtimes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        // Generate booking reference
        $booking_reference = 'BK-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'showtime_id' => $request->showtime_id,
            'booking_reference' => $booking_reference,
            'total_amount' => $request->total_amount,
            'booking_fee' => $request->booking_fee,
            'discount_amount' => $discount,
            'final_amount' => $final_amount,
            'status' => $request->status,
            'expires_at' => showtimes::find($request->showtime_id)->end_time, // Expires when movie ends
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
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
