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
    public function index()
    {
        //


       $hall_cinema = Hall_cinema::where('status', 'active')->paginate(10);
       $hall_location = Hall_location::all();
    return  view('Backend.HallCinema.index' , compact('hall_cinema', 'hall_location'));
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
        return view('Backend.HallCinema.create' , compact('hall_cinema','hall_location'));

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
    public function edit(Hall_cinema $hallcinema)
    {
        Hall_cinema::all();
        $hall_location = Hall_location::all();

//        if (request()->ajax()) {
//            return view('Backend.HallCinema.edit', compact('hallcinema', 'hall_location'))->render();
//        }

        return view('Backend.HallCinema.edit', compact('hallcinema', 'hall_location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall_cinema $hallcinema)
    {
        //
       $data =  $request->validate([
            'cinema_name' => 'required|string|max:255',
            'hall_type' => 'required|in:standard,vip,imax,4dx,3d,dolby_atmos,premium,outdoor,private',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'hall_location_id' => 'required|exists:hall_locations,id',

        ]);
       $hallcinema->update($data);
       return redirect()->route('hallCinema.index')->with('success', 'Hall updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_cinema $hallcinema)
    {
        //
        $hallcinema->status = 'inactive';
        $hallcinema->save();
        return redirect()->route('hallCinema.index')->with('success', 'Hall deleted successfully.');
    }
}
