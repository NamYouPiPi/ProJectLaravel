<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
use App\Models\Hall_location;
use Illuminate\Http\Request;

class HallLocationController extends Controller
{
    public function __construct()
        {
            $this->middleware('permission:view_hall_locations')->only(['index', 'show', 'analytics', 'search']);
            $this->middleware('permission:create_hall_locations')->only(['create', 'store']);
            $this->middleware('permission:edit_hall_locations')->only(['edit', 'update']);
            $this->middleware('permission:delete_hall_locations')->only(['destroy']);
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Hall_location::withCount('hall_cinema');

        // Search by name, address, city, or state
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%")
                  ->orWhere('country', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by city
        if ($request->filled('city') && $request->city !== 'all') {
            $query->where('city', $request->city);
        }

        // Filter by state
        if ($request->filled('state') && $request->state !== 'all') {
            $query->where('state', $request->state);
        }

        // Filter by country
        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country', $request->country);
        }

        // Get distinct values for filters
        $cities = Hall_location::select('city')->distinct()->whereNotNull('city')->orderBy('city')->pluck('city');
        $states = Hall_location::select('state')->distinct()->whereNotNull('state')->orderBy('state')->pluck('state');
        $countries = Hall_location::select('country')->distinct()->whereNotNull('country')->orderBy('country')->pluck('country');

        // Order by created_at desc and paginate
        $hallocation = $query->orderBy('created_at', 'desc')->paginate(12);

        // Statistics for dashboard
        $totalLocations = Hall_location::count();
        $activeLocations = Hall_location::where('status', 'active')->count();
        $inactiveLocations = Hall_location::where('status', 'inactive')->count();
        $totalCinemas = Hall_cinema::count();

        return view("Backend.Hall_Location.index", compact(
            'hallocation',
            'cities',
            'states',
            'countries',
            'totalLocations',
            'activeLocations',
            'inactiveLocations',
            'totalCinemas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('Backend.Hall_Location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'country'    => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
            'postal_code'=> 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
        ]);
        Hall_location::create($data);

        return redirect()->route('hall_locations.index')->with('success', 'Hall_location created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hall_location  $hall_location
     * @return \Illuminate\Http\Response
     */
    public function show(Hall_location $hall_location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hall_location  $hall_location
     * @return \Illuminate\Http\Response
     */
    public function edit(Hall_location $hall_location)
    {
        //
        return  view('Backend.Hall_Location.edit', compact('hall_location'));
//        return  view('Backend.Hall_Location.edit', compact('hall_location'));
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall_location  $hall_location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall_location $hall_location)
    {
        //
        // dd($request->all());
         $data = $request->validate([
            'name'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'country'    => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
            'postal_code'=> 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
        ]);

        $hall_location->update($data);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hall location updated successfully!',
                'data' => $hall_location
            ]);
        }

        return redirect()->route('hall_locations.index')->with('success', 'Hall_location updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall_location  $hall_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_location $hall_location)
    {
        //
        $hall_location->delete();
        return redirect()->route('hall_locations.index')->with('success', 'Hall_location deleted successfully!');
    }

    /**
     * Search locations via AJAX
     */
    public function search(Request $request)
    {
        $query = Hall_location::withCount('hall_cinema');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%");
            });
        }

        $locations = $query->where('status', 'active')->limit(10)->get();

        return response()->json([
            'success' => true,
            'data' => $locations->map(function($location) {
                return [
                    'id' => $location->id,
                    'name' => $location->name,
                    'address' => $location->address,
                    'city' => $location->city,
                    'state' => $location->state,
                    'country' => $location->country,
                    'phone' => $location->phone,
                    'halls_count' => $location->hall_cinema_count,
                    'status' => $location->status
                ];
            })
        ]);
    }

    /**
     * Get location details with cinema halls for customers
     */
    public function details($id)
    {
        $location = Hall_location::with(['hall_cinema' => function($query) {
            $query->where('status', 'active');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'location' => [
                'id' => $location->id,
                'name' => $location->name,
                'address' => $location->address,
                'city' => $location->city,
                'state' => $location->state,
                'country' => $location->country,
                'phone' => $location->phone,
                'status' => $location->status,
                'halls' => $location->hall_cinema->map(function($hall) {
                    return [
                        'id' => $hall->id,
                        'cinema_name' => $hall->cinema_name,
                        'hall_type' => $hall->hall_type,
                        'total_seats' => $hall->total_seats
                    ];
                })
            ]
        ]);
    }

    /**
     * Get nearby locations based on city (for customer convenience)
     */
    public function nearby(Request $request)
    {
        $city = $request->get('city');
        $state = $request->get('state');

        $query = Hall_location::with('hall_cinema')
            ->where('status', 'active');

        if ($city) {
            $query->where('city', $city);
        }

        if ($state) {
            $query->where('state', $state);
        }

        $locations = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'locations' => $locations->map(function($location) {
                return [
                    'id' => $location->id,
                    'name' => $location->name,
                    'address' => $location->address,
                    'city' => $location->city,
                    'state' => $location->state,
                    'phone' => $location->phone,
                    'halls_count' => $location->hall_cinema->count(),
                    'total_seats' => $location->hall_cinema->sum('total_seats')
                ];
            })
        ]);
    }

    /**
     * Get analytics data for hall locations
     */
    public function analytics()
    {
        $totalLocations = Hall_location::count();
        $activeLocations = Hall_location::where('status', 'active')->count();
        $inactiveLocations = Hall_location::where('status', 'inactive')->count();

        // Location distribution by city/state
        $cityDistribution = Hall_location::select('city')
            ->selectRaw('COUNT(*) as locations_count')
            ->selectRaw('COUNT(CASE WHEN status = "active" THEN 1 END) as active_count')
            ->groupBy('city')
            ->orderBy('locations_count', 'desc')
            ->get();

        $stateDistribution = Hall_location::select('state')
            ->selectRaw('COUNT(*) as locations_count')
            ->selectRaw('COUNT(CASE WHEN status = "active" THEN 1 END) as active_count')
            ->groupBy('state')
            ->orderBy('locations_count', 'desc')
            ->get();

        // Locations with most cinema halls
        $topLocations = Hall_location::withCount('hall_cinema')
            ->where('status', 'active')
            ->orderBy('hall_cinema_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'total_locations' => $totalLocations,
            'active_locations' => $activeLocations,
            'inactive_locations' => $inactiveLocations,
            'city_distribution' => $cityDistribution,
            'state_distribution' => $stateDistribution,
            'top_locations' => $topLocations
        ]);
    }

    /**
     * Get all cities for location picker (customer-friendly)
     */
    public function cities()
    {
        $cities = Hall_location::where('status', 'active')
            ->select('city')
            ->selectRaw('COUNT(*) as locations_count')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }
}
