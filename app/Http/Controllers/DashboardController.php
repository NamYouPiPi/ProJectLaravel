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
    $now = now();
    $lastMonth = now()->subMonth();

    $bookingsThisMonth = \App\Models\Booking::whereYear('created_at', $now->year)
        ->whereMonth('created_at', $now->month)
        ->count();

    $bookingsLastMonth = \App\Models\Booking::whereYear('created_at', $lastMonth->year)
        ->whereMonth('created_at', $lastMonth->month)
        ->count();

    $bookingGrowth = $bookingsLastMonth > 0
        ? round((($bookingsThisMonth - $bookingsLastMonth) / $bookingsLastMonth) * 100, 2)
        : 0;

    $revenueThisMonth = \App\Models\Booking::where('status', 'paid')
        ->whereYear('created_at', $now->year)
        ->whereMonth('created_at', $now->month)
        ->sum('total_price');

    $revenueLastMonth = Booking::where('status', 'paid')
        ->whereYear('created_at', $lastMonth->year)
        ->whereMonth('created_at', $lastMonth->month)
        ->sum('total_price');

    $revenueGrowth = $revenueLastMonth > 0
        ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 2)
        : 0;

    $processedPayments = Booking::where('status', 'paid')->sum('total_price');
$payments = Booking::with('customer')
    ->where('status', 'paid')
    ->orderByDesc('updated_at')
    ->limit(10)
    ->get();

    return view('Backend.Dashboard.index', compact(
        'bookingsThisMonth',
        'bookingsLastMonth',
        'bookingGrowth',
        'revenueThisMonth',
        'revenueLastMonth',
        'revenueGrowth',
        'processedPayments'
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
