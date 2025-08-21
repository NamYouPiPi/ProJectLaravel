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
    public function index(Request $request)
    {
        // Dashboard Statistics
        $stats = [
            'total_movies' => Movies::count(),
            'active_movies' => Movies::where('status', 'active')->count(),
            'inactive_movies' => Movies::where('status', 'inactive')->count(),
            'by_genre' => Genre::withCount('movies')->get(),

        ];

        $query = Movies::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by genre
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        // Filter by supplier
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }



        // Search by name/title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Get the data with pagination
        $movies = $query->paginate(10);
        $genres = Genre::all();
        $classifications = Classification::all();
        $suppliers = Supplier::all();

        // Pass stats to view
        return view('Backend.Movies.index', compact('movies', 'genres', 'classifications', 'suppliers', 'stats'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $genres = Genre::all();
        $classifications = Classification::all();
        $suppliers = Supplier::all();
        return view('Backend.Movies.create', [
            'genres' => $genres,
            'classifications' => $classifications,
            'suppliers' => $suppliers
        ]);
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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|string
     */
public function edit($id)
{
    $movie = Movies::findOrFail($id);
    $genres = Genre::all();
    $suppliers = Supplier::all();
    $classifications = Classification::all();

    return view('Backend.Movies.edit', compact('movie', 'genres', 'suppliers', 'classifications'));
}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Movies $movie): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
{
    try {
        \Illuminate\Support\Facades\Log::info('Movie Update Request', [
            'movie_id'      => $movie->id,
            'request_data'  => $request->except(['poster', 'trailer']),
            'has_poster'    => $request->hasFile('poster'),
            'has_trailer'   => $request->hasFile('trailer')
        ]);

        $movies = $movie; // Keep $movies for compatibility with existing code
    $request->validate([
        'title'                 => 'required|string|max:255',
        'duration_minutes'      => 'required|integer',
        'director'              => 'required|string|max:255',
        'description'           => 'required|string',
        'language'              => 'required|string|max:255',
        'status'                => 'required|in:active,inactive',
        'release_date'          => 'required|date',
        'genre_id'              => 'required|exists:genres,id',
        'classification_id'     => 'required|exists:classifications,id',
        'supplier_id'           => 'required|exists:suppliers,id',
        'poster'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'trailer'               => 'nullable|file|mimes:mp4,mov,avi|max:51200',
    ]);

    // Handle poster
    if ($request->hasFile('poster')) {
        if ($movies->poster) {
            Storage::disk('public')->delete($movies->poster);
        }
        $PosterPath = $request->file('poster')->store('Poster', 'public');
    } else {
        $PosterPath = $movies->poster;
    }

    // Handle trailer
    if ($request->hasFile('trailer')) {
        if ($movies->trailer) {
            Storage::disk('public')->delete($movies->trailer);
        }
        $trailerPath = $request->file('trailer')->store('Trailer', 'public');
    } else {
        $trailerPath = $movies->trailer;
    }

    $movies->update([
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

    // Add AJAX response support
    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Movie updated successfully!']);
    }

    return redirect()->route('movies.index')->with('success', 'Movies updated successfully!');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Movie update failed', ['movie_id' => $movie->id, 'error' => $e->getMessage()]);

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Failed to update movie.'], 500);
        }

        return redirect()->route('movies.index')->with('error', 'Failed to update movie.');
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movies $movie)
    {
        $movies = $movie; // Keep compatibility
        $movies->status = "inactive";
        $movies->save();
        return redirect()->route('movies.index')->with('success', 'Movies deleted successfully!');
    }
}
