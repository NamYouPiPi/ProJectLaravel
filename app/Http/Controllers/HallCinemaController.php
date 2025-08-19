<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
use App\Models\Hall_location;
use Illuminate\Http\Request;

class HallCinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Hall_cinema::with('hall_location');

        // Search by cinema name or location name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cinema_name', 'LIKE', "%{$search}%")
                  ->orWhere('hall_type', 'LIKE', "%{$search}%")
                  ->orWhereHas('hall_location', function($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%")
                           ->orWhere('address', 'LIKE', "%{$search}%")
                           ->orWhere('city', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default to show active if no specific status filter
            if (!$request->filled('status')) {
                $query->where('status', 'active');
            }
        }

        // Filter by hall type
        if ($request->filled('hall_type') && $request->hall_type !== 'all') {
            $query->where('hall_type', $request->hall_type);
        }

        // Filter by location
        if ($request->filled('location') && $request->location !== 'all') {
            $query->where('hall_location_id', $request->location);
        }

//         Get distinct hall types for filter
//        $hallTypes = Hall_cinema::select('hall_type')->distinct()->orderBy('hall_type')->pluck('hall_type');

        // Get all locations for filter
        $hall_location = Hall_location::where('status', 'active')->orderBy('name');

        // Order by created_at desc and paginate
        $hall_cinema = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics for dashboard
        $totalHalls = Hall_cinema::count();
        $activeHalls = Hall_cinema::where('status', 'active')->count();
        $inactiveHalls = Hall_cinema::where('status', 'inactive')->count();
        $totalSeats = Hall_cinema::where('status', 'active')->sum('total_seats');

        return view('Backend.HallCinema.index', compact(
            'hall_cinema',
            'hall_location',
//            'hallTypes',
            'totalHalls',
            'activeHalls',
            'inactiveHalls',
            'totalSeats'
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
        $hall_cinema = Hall_cinema::all();
        $hall_location = Hall_location::all();
        return view('Backend.HallCinema.index' , compact('hall_cinema','hall_location'));

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
        // dd($request->all());
         $request->validate([
            'cinema_name' => 'required|string|max:255',
            'hall_type' => 'required|in:standard,vip,imax,4dx,3d,dolby_atmos,premium,outdoor,private',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'hall_location_id' => 'required|exists:hall_locations,id',
        ]);
        try{
        Hall_cinema::create([
            'cinema_name'=> $request->cinema_name,
            'hall_type'=> $request->hall_type,
            'total_seats'=> $request->total_seats,
            'status'=> $request->status,
            'hall_location_id'=> $request->hall_location_id,
        ]);
        return redirect()->route('hallCinema.index')->with('success', 'Hall created successfully.');
      }catch (\Exception $e){
          return redirect()->route('hallCinema.index')->with('error', 'Failed to create hall.');
      }

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function show(Hall_cinema $hall_cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function edit(Hall_cinema $hallCinema)
    {
        $hall_location = Hall_location::all();

       if (request()->ajax()) {
           return view('Backend.HallCinema.edit', compact('hallCinema', 'hall_location'))->render();
       }

        return view('Backend.HallCinema.edit', compact('hallCinema', 'hall_location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall_cinema $hallCinema)
    {
        //
       $data =  $request->validate([
            'cinema_name' => 'required|string|max:255',
            'hall_type' => 'required|in:standard,vip,imax,4dx,3d,dolby_atmos,premium,outdoor,private',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'hall_location_id' => 'required|exists:hall_locations,id',

        ]);
       $hallCinema->update($data);

       // Return JSON response for AJAX requests
    //    if ($request->expectsJson()) {
    //        return response()->json([
    //            'success' => true,
    //            'message' => 'Hall cinema updated successfully!',
    //            'data' => $hallCinema
    //        ]);
    //    }

        return redirect()->route('hallCinema.index')->with('success', 'Hall Update successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_cinema $hallCinema)
    {
        //
        $hallCinema->status = 'inactive';
        $hallCinema->save();
        return redirect()->route('hallCinema.index')->with('success', 'Hall deleted successfully.');
    }

    /**
     * Search hall cinemas via AJAX
     */
    public function search(Request $request)
    {
        $query = Hall_cinema::with('hall_location');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cinema_name', 'LIKE', "%{$search}%")
                  ->orWhere('hall_type', 'LIKE', "%{$search}%")
                  ->orWhereHas('hall_location', function($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%")
                           ->orWhere('address', 'LIKE', "%{$search}%")
                           ->orWhere('city', 'LIKE', "%{$search}%");
                  });
            });
        }

        $halls = $query->orderBy('created_at', 'desc')->limit(10)->get();

        return response()->json([
            'success' => true,
            'data' => $halls->map(function($hall) {
                return [
                    'id' => $hall->id,
                    'cinema_name' => $hall->cinema_name,
                    'hall_type' => $hall->hall_type,
                    'total_seats' => $hall->total_seats,
                    'status' => $hall->status,
                    'location_name' => $hall->hall_location->name ?? 'N/A'
                ];
            })
        ]);
    }

    /**
     * Get analytics data for hall cinema
     */
    public function analytics()
    {
        $totalHalls = Hall_cinema::count();
        $activeHalls = Hall_cinema::where('status', 'active')->count();
        $inactiveHalls = Hall_cinema::where('status', 'inactive')->count();
        $totalSeats = Hall_cinema::where('status', 'active')->sum('total_seats');

        // Hall types distribution
        $hallTypeStats = Hall_cinema::where('status', 'active')
            ->selectRaw('hall_type, COUNT(*) as count, SUM(total_seats) as total_seats')
            ->groupBy('hall_type')
            ->orderBy('count', 'desc')
            ->get();

        // Location wise distribution
        $locationStats = Hall_cinema::with('hall_location')
            ->where('status', 'active')
            ->selectRaw('hall_location_id, COUNT(*) as halls_count, SUM(total_seats) as total_seats')
            ->groupBy('hall_location_id')
            ->orderBy('halls_count', 'desc')
            ->get();

        return response()->json([
            'total_halls' => $totalHalls,
            'active_halls' => $activeHalls,
            'inactive_halls' => $inactiveHalls,
            'total_seats' => $totalSeats,
            'hall_type_stats' => $hallTypeStats,
            'location_stats' => $locationStats
        ]);
    }
}
