<?php

namespace App\Http\Controllers;

use App\Models\Seat_type;
use Illuminate\Http\Request;

class SeatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $seat_types = Seat_type::paginate(10); // remove where('status', 'active')
        return view('Backend.SeatsType.index', compact('seat_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Backend.SeatsType.index');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);
        Seat_type::create($request->all());
        return redirect()->route('seatTypes.index')->with('success', 'Seat type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seat_type  $seat_type
     * @return \Illuminate\Http\Response
     */
    public function show(Seat_type $seat_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seat_type  $seatType
     * @return \Illuminate\Http\Response
     */
    public function edit(Seat_type $seatType)
    {
        return view('Backend.SeatsType.edit', compact('seatType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seat_type  $seat_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seat_type $seat_type)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);
        $seat_type->update($request->all());
        return redirect()->route('seatTypes.index')->with('success', 'Seat type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seat_type  $seatType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seat_type $seatType)
    {

        $seatType->status = 'inactive'; // Correct field name is 'status', not 'active'
        $seatType->save();
        return redirect()->route('seatTypes.index')->with('success', 'Seat type deleted successfully');
    }
}

