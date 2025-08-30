<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Movies;
use App\Models\Showtimes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Calculate monthly revenue
        $startOfMonth = Carbon::now()->startOfMonth();
        $totalRevenue = Booking::where('status', 'confirmed')
                            ->where('created_at', '>=', $startOfMonth)
                            ->sum('total_amount');

        // Get monthly bookings count
        $totalBookings = Booking::where('created_at', '>=', $startOfMonth)->count();

        // Get active movies count
        $activeMovies = Movies::where('status', 'active')->count();

        // Get pending bookings count
        $pendingBookings = Booking::where('status', 'pending')->count();

        // Get recent bookings with safety checks
        try {
            $recentBookings = Booking::with([
                'customer:id,name',
                'showtime:id,start_time',
                'showtime.movie:id,title',
                'showtime.hall:id,cinema_name,capacity'
            ])
            ->whereHas('customer')
            ->whereHas('showtime.movie')
            ->whereHas('showtime.hall')
            ->whereNotNull('booking_reference')
            ->latest()
            ->take(5)
            ->get();
        } catch (\Exception $e) {
            $recentBookings = collect(); // Empty collection as fallback
        }

        // Get upcoming showtimes with safety checks
        try {
            $now = Carbon::now();
            $upcomingShowtimes = Showtimes::with([
                'movie:id,title',
                'hall:id,cinema_name,capacity'
            ])
            ->whereHas('movie')
            ->whereHas('hall')
            ->where('start_time', '>', $now)
            ->orderBy('start_time')
            ->take(5)
            ->get();

            // Add booked seats count to each showtime
            foreach ($upcomingShowtimes as $showtime) {
                $bookedSeatsCount = DB::table('booking_seats')
                    ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
                    ->where('bookings.showtime_id', $showtime->id)
                    ->where('bookings.status', '!=', 'cancelled')
                    ->where('booking_seats.status', 'active')
                    ->count();

                $showtime->booked_seats_count = $bookedSeatsCount;
            }
        } catch (\Exception $e) {
            $upcomingShowtimes = collect(); // Empty collection as fallback
        }

        // Get monthly revenue data for chart
        // $monthlyRevenue = Booking::where('status', 'confirmed')
        //                     ->whereYear('created_at', Carbon::now()->year)
        //                     ->select(
        //                         DB::raw('MONTH(created_at) as month'),
        //                         DB::raw('SUM(final_amount) as revenue')
        //                     )
        //                     ->groupBy('month')
        //                     ->get()
        //                     ->pluck('revenue', 'month')
        //                     ->toArray();

        // Get top movies by booking count
        $topMovies = DB::table('bookings')
                    ->join('showtimes', 'bookings.showtime_id', '=', 'showtimes.id')
                    ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
                    ->where('bookings.status', '!=', 'cancelled')
                    ->select('movies.title', DB::raw('COUNT(*) as booking_count'))
                    ->groupBy('movies.id', 'movies.title')
                    ->orderBy('booking_count', 'desc')
                    ->take(5)
                    ->get();

        return view('Backend.Dashboard.index', compact(
            'totalRevenue',
            'totalBookings',
            'activeMovies',
            'pendingBookings',
            'recentBookings',
            'upcomingShowtimes',
            // 'monthlyRevenue',
            'topMovies'
        ));
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $currentYear = Carbon::now()->year;

        if ($period === 'weekly') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $data = Booking::where('status', 'confirmed')
                        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                        ->select(
                            DB::raw('DAYOFWEEK(created_at) as day'),
                            DB::raw('SUM(final_amount) as revenue')
                        )
                        ->groupBy('day')
                        ->get()
                        ->pluck('revenue', 'day')
                        ->toArray();

            // Format for chart.js
            $labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            $chartData = [];

            for ($i = 1; $i <= 7; $i++) {
                $chartData[] = $data[$i] ?? 0;
            }

            return response()->json([
                'labels' => $labels,
                'data' => $chartData
            ]);
        } elseif ($period === 'yearly') {
            $data = Booking::where('status', 'confirmed')
                        ->whereYear('created_at', '>=', $currentYear - 5)
                        ->select(
                            DB::raw('YEAR(created_at) as year'),
                            DB::raw('SUM(final_amount) as revenue')
                        )
                        ->groupBy('year')
                        ->get()
                        ->pluck('revenue', 'year')
                        ->toArray();

            // Format for chart.js
            $labels = [];
            $chartData = [];

            for ($year = $currentYear - 5; $year <= $currentYear; $year++) {
                $labels[] = $year;
                $chartData[] = $data[$year] ?? 0;
            }

            return response()->json([
                'labels' => $labels,
                'data' => $chartData
            ]);
        } else {
            // Monthly (default)
            $data = Booking::where('status', 'confirmed')
                        ->whereYear('created_at', $currentYear)
                        ->select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('SUM(final_amount) as revenue')
                        )
                        ->groupBy('month')
                        ->get()
                        ->pluck('revenue', 'month')
                        ->toArray();

            // Format for chart.js
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $chartData = [];

            for ($month = 1; $month <= 12; $month++) {
                $chartData[] = $data[$month] ?? 0;
            }

            return response()->json([
                'labels' => $labels,
                'data' => $chartData
            ]);
        }
    }
}
