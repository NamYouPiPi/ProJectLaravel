<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
use App\Models\Movies;
use App\Models\showtimes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShowtimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {

            $showtimes = showtimes::with('movie', 'hall')->where('is_active', 'active')->paginate(10);
            return view('Backend.Showtime.index', compact('showtimes'));
        }

    public function upcoming()
    {
        $showtime = showtimes::where('start_time', '>', now())->get();
        return view('Backend.showtimes.index', compact('showtime'));
    }

    public function ongoing()
    {
        $showtimes = showtimes::where('start_time', '<=', now())
                              ->where('end_time', '>=', now())
                              ->get();
        return view('Backend.Showtime.index', compact('showtimes'));
    }

    public function ended()
    {
        $showtimes = showtimes::where('end_time', '<', now())->get();
        return view('Backend.Showtime.index', compact('showtimes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $movies = Movies::all();
        $hallCinema = Hall_cinema::all();
        return view('Backend.Showtime.create',compact('movies','hallCinema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request ,showtimes $showtime)
    {
        //
        // dd($request->all());
         $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'hall_id' => 'required|exists:hall_cinemas,id',
        'start_time' => 'required|date',
        'base_price' => 'required|numeric|min:0',
        // End time is calculated, not required from input
    ]);

    // Get the movie duration
    $movie = Movies::findOrFail(id: $request->movie_id);
    $durationInMinutes = $movie->duration_minutes;

    // Calculate end time based on start time and movie duration
    $startTime = Carbon::parse($request->start_time);
    $endTime = $startTime->copy()->addMinutes($durationInMinutes);

    // Create the s
        $showtime::create([
           'movie_id' => $request->movie_id,
        'hall_id' => $request->hall_id,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'base_price' => $request->base_price,
        'status' => $request->status,
        'is_active' => 'active',
        ]);
        return redirect()->route('showtimes.index')->with('success', 'Showtime created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\showtimes  $showtimes
     * @return \Illuminate\Http\Response
     */
    public function show(showtimes $showtimes)
    {
        //
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\showtimes  $showtime
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(showtimes $showtime)
    {
//        dd($showtime);
        // $showtime = showtimes::findOrFail($id);
        $movies = Movies::all();
        $hallCinema = Hall_cinema::all();
        return view('Backend.Showtime.edit', compact('showtime', 'movies', 'hallCinema'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\showtimes  $showtime
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, showtimes $showtime)
    {
        //
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:hall_cinemas,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'base_price' => 'required|numeric|min:0',
            'status' => 'required|in:upcoming,ongoing,ended',
            'is_active' => 'required|in:active,inactive',
        ]);

        $showtime->update($data);

        return redirect()->route('showtimes.index')->with('success', 'Showtime updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\showtimes  $showtime
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function destroy(showtimes $showtime)
    {
        //
        // $showtime->delete();
      $showtime->is_active = 'inactive';
      $showtime->save();
      return redirect()->route('showtimes.index')->with('success','Status was changed to inactive');
    }
}
