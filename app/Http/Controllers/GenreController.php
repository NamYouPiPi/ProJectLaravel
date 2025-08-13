<?php

namespace App\Http\Controllers;

use App\Models\genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $genres = Genre::all();
        return view('Backend.Genre.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  view('Backend.Genre.create');
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
        $data =$request->validate([
            'main_genre' => 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            ]);
        Genre::create($data);
//        genre::create($request->all() + $data);
        return redirect()->route('genre.index')->with('success', 'Genre created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\genre  $gendre
     * @return \Illuminate\Http\Response
     */
    public function show(genre $gendre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(genre $genre)
    {
        //
        return  view('Backend.Genre.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, genre $genre)
    {
        //
        $data =$request->validate([
            'main_genre' => 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            ]);
        $genre->update($data);
        return redirect()->route('genre.index')->with('success', 'Genre updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(genre $genre)
    {
        //
        $genre->delete();
        return redirect()->route('genre.index')->with('success', 'Genre deleted successfully!');
    }
}
