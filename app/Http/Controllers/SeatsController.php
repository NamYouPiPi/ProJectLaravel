<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
use App\Models\Movies;
use App\Models\Seat_type;
use App\Models\Seats;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_seats')->only(['index', 'show']);
        $this->middleware('permission:create_seats')->only(['create', 'store']);
        $this->middleware('permission:edit_seats')->only(['edit', 'update']);
        $this->middleware('permission:delete_seats')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        //
        $Seats = Seats::paginate(10);
        return view('Backend.Seats.index', compact('Seats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create()
    {
        //
        return view('Backend.Seats.create');
    }
    public function showBooking($movieId)
{
    $movie = Movies::with(['showtimes'])->findOrFail($movieId);
    $hallId = $movie->hall_id; // or get from showtime/hall relationship

    // Get all seats for the hall
    $seats = Seats::where('hall_id', $hallId)->orderBy('seat_row')->orderBy('seat_number')->get();

    // Group seats by row
    $seatRows = $seats->groupBy('seat_row');

    return view('Frontend.Booking.create', compact('movie', 'seatRows'));
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
//        dd($request->all());
       $data= $request->validate([
            'hall_id' => 'required|exists:hall_cinemas,id',
            'seat_type_id' => 'required|exists:seat_types,id',
            'seat_number' => 'required|string|max:255',
            'status' => 'required|in:available,reserved,booked,cancelled, blocked,broken',
            'seat_row' => 'required|string|max:255',
        ]);
        Seats::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Seat created successfully.',
                'data' => $data
            ]);
        }

        return  redirect()->route('seats.index')->with('success', 'Seat created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seats  $seats
     * @return \Illuminate\Http\Response
     */
    public function show(Seats $seats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seats  $seat
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(Seats $seat)
        {
            $hallCinema  = Hall_cinema::all();
            $seatsType  = Seat_type::all();
            return view('Backend.Seats.edit', compact('seat', 'hallCinema', 'seatsType'));
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seats  $seat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Seats $seat)
    {
        $data = $request->validate([
            'hall_id' => 'required|exists:hall_cinemas,id',
            'seat_type_id' => 'required|exists:seat_types,id',
            'seat_number' => 'required|string|max:255',
            'status' => 'required|in:available,reserved,booked,cancelled,blocked,broken',
            'seat_row' => 'required|string|max:255',
        ]);

        $seat->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Seat updated successfully.',
                'data' => $seat
            ]);
        }

        return redirect()->route('seats.index')->with('success', 'Seat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $seat = Seats::findOrFail($id);
        $seat->status = 'blocked';
        $seat->save();

        // Use redirect() with flash message, not view()
        return redirect()->route('seats.index')->with('success', 'Seat blocked successfully.');
    }

    public function showBookingUI()
    {
        $seats = Seats::select([
            'hall_id',
            'seat_type_id',
            'seat_number',
            'seat_row',
            'status',
            'created_at'
        ])->with(['hall', 'seatType'])->get();

        // Prepare data for JS (add hallName and seatsType)
        $seatData = $seats->map(function($seat) {
            return [
                'hallName' => $seat->hall->name ?? '',
                'seatsType' => $seat->seatType->name ?? '',
                'price' => $seat->seatType->price ?? 0,
                'seatNumber' => $seat->seat_number,
                'seatRow' => $seat->seat_row,
                'status' => $seat->status,
                'createdAt' => $seat->created_at->format('Y-m-d'),
            ];
        });

        return view('Frontend.Booking.index', [
            'seatData' => $seatData,
            // ...other data if needed...
        ]);
    }
}

