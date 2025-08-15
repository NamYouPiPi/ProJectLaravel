<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Genre;
use App\Models\Movies;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $movies = Movies::paginate(10);
        $classifications = Classification::all();
        $suppliers = Supplier::all();
        return view('Backend.movies.index', compact('movies', 'classifications', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */public function create()
{
    $genres = Genre::all();
    $classifications = Classification::all();
    $suppliers = Supplier::all();

    return view('Backend.Movies.create')->with('genres', $genres)->with('classifications', $classifications)->with('suppliers', $suppliers);
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
   {
//        dd($request->all());
        $request->validate([
            'title'             => 'required|string|max:255',
            'duration_minutes'  => 'required|integer',
            'director'          => 'required|string|max:255',
            'description'       => 'required|string', // no max
            'language'          => 'required|string|max:255',
            'status'            => 'required|in:active,inactive',
            'release_date'      => 'required|date',
            'genre_id'          => 'required|exists:genres,id',
            'classification_id' => 'required|exists:classifications,id',
            'supplier_id'       => 'required|exists:suppliers,id',
            'poster'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'trailer'           => 'nullable|file|mimes:mp4,mov,avi|max:51200',
        ]);

        $trailerPath = null;
        $PosterPath = null;
        if ($request->hasFile('poster')) {
            $PosterPath = $request->file('poster')->store('Poster', 'public');
        }

        if ($request->hasFile('trailer')) {
            $trailerPath = $request->file('trailer')->store('Trailer', 'public');
        }

        Movies::create([
            'title'             => $request->title,
            'duration_minutes'  => $request->duration_minutes,
            'director'          => $request->director,
            'description'       => $request->description,
            'language'          => $request->language,
            'status'            => $request->status,
            'release_date'      => $request->release_date,
            'genre_id'          => $request->genre_id,
            'classification_id' => $request->classification_id,
            'supplier_id'       => $request->supplier_id,
            'poster'            => $PosterPath,
            'trailer'           => $trailerPath,

        ]);

        return redirect()->route('movies.index')->with('success', 'Movies created successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function show(Movies $movies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function edit(Movies $movies)
    {
        // $movies = Movies::findOrFail($id);
        $genres = Genre::all();
        $classifications = Classification::all();
        $suppliers = Supplier::all();

        return view('Backend.Movies.edit', compact('movies', 'genres', 'classifications', 'suppliers'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movies $movies)
    {
        //
        $request->validate([
            'title'             => 'required|string|max:255',
            'duration_minutes'  => 'required|integer',
            'director'          => 'required|string|max:255',
            'description'       => 'required|string', // no max
            'language'          => 'required|string|max:255',
            'status'            => 'required|in:active,inactive',
            'release_date'      => 'required|date',
            'genre_id'          => 'required|exists:genres,id',
            'classification_id' => 'required|exists:classifications,id',
            'supplier_id'       => 'required|exists:suppliers,id',
            'poster'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'trailer'           => 'nullable|file|mimes:mp4,mov,avi|max:51200',
        ]);

        $trailerPath = null;
        $PosterPath = null;
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($movies->poster) {
                Storage::disk('public')->delete($movies->poster);
            }
            $PosterPath = $request->file('poster')->store('Poster', 'public');
        } else {
            $PosterPath = $movies->poster; // Keep old poster if no new one is uploaded
        }
        if ($request->hasFile('trailer')) {
            // Delete old trailer if exists
            if ($movies->trailer) {
                Storage::disk('public')->delete($movies->trailer);
            }
            $trailerPath = $request->file('trailer')->store('Trailer', 'public');
        } else {
            $trailerPath = $movies->trailer; // Keep old trailer if no new one is uploaded
        }

        Movies::update([
            'title'             => $request->title,
            'duration_minutes'  => $request->duration_minutes,
            'director'          => $request->director,
            'description'       => $request->description,
            'language'          => $request->language,
            'status'            => $request->status,
            'release_date'      => $request->release_date,
            'genre_id'          => $request->genre_id,
            'classification_id' => $request->classification_id,
            'supplier_id'       => $request->supplier_id,
            'poster'            => $PosterPath,
            'trailer'           => $trailerPath,

        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movies $movies)
    {
        //
        if ($movies->poster) {
            Storage::disk('public')->delete($movies->poster);
        }
        if ($movies->trailer) {
            Storage::disk('public')->delete($movies->trailer);
        }

        $movies->delete();
        return redirect()->route('movies.index')->with('success', 'Movies deleted successfully!');
    }
}
