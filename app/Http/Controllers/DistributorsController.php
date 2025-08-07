<?php

namespace App\Http\Controllers;

use App\Models\Distributors;
use Illuminate\Http\Request;

class DistributorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $distributors  = Distributors::all();
        return view('distributors.index' , compact('distributors'));
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
     * @param  \App\Models\Distributors  $distributors
     * @return \Illuminate\Http\Response
     */
    public function show(Distributors $distributors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Distributors  $distributors
     * @return \Illuminate\Http\Response
     */
    public function edit(Distributors $distributors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Distributors  $distributors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distributors $distributors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Distributors  $distributors
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distributors $distributors)
    {
        //
    }
}
