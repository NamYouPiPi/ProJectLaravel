<?php

namespace App\Http\Controllers;

use App\Models\Hall_cinema;
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
       $hall_cinema = Hall_cinema::all();
       return view('hall_cinema.index', compact('hall_cinema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
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
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function edit(Hall_cinema $hall_cinema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall_cinema $hall_cinema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall_cinema  $hall_cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_cinema $hall_cinema)
    {
        //
    }
}
