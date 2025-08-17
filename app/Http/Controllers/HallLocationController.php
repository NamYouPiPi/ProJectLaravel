<?php

namespace App\Http\Controllers;

use App\Models\Hall_location;
use Illuminate\Http\Request;

class HallLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hallocation = Hall_location::all();
        return view("Backend.Hall_Location.index" , compact('hallocation'));
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
         $request->validate([
            'name'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'country'    => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
            'postal_code'=> 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
        ]);
        Hall_location::update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'city' => $request->city,
            'country' => $request->country,
            'status' => $request->status,
            'postal_code' => $request->postal_code,
            'state' => $request->state,
        ]);
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
}
