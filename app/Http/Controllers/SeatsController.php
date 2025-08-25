<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
use App\Models\Seat_type;
use App\Models\Seats;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
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
            return view('Backend.Seats.edit', compact('seat', 'hallCinema', 'seatsType' ,'seatsType'));
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seats  $seats
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Seats $seats)
    {
        $data = $request->validate([
            'hall_id' => 'required|exists:hall_cinemas,id',
            'seat_type_id' => 'required|exists:seat_types,id',
            'seat_number' => 'required|string|max:255',
            'status' => 'required|in:available,reserved,booked,cancelled,blocked,broken',
            'seat_row' => 'required|string|max:255',
        ]);
        $seats->update($data);
        return  redirect()->route('seats.index')->with('success', 'Seat updated successfully.');
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
}

