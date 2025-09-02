<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Genre;
use App\Models\Movies;
use App\Models\Seats;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
  public function __construct()
    {
        // Apply middleware to admin routes only, not to the public home page
        $this->middleware('auth')->except(['home']);
        $this->middleware('permission:view_movies')->only(['index', 'show']);
        $this->middleware('permission:create_movies')->only(['create', 'store']);
        $this->middleware('permission:edit_movies')->only(['edit', 'update']);
        $this->middleware('permission:delete_movies')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index(Request $request)
    {
        // Dashboard Statistics
        $totalMovies = Movies::count();
        $activeMovies = Movies::where('status', 'active')->count();
        $inactiveMovies = Movies::where('status', 'inactive')->count();

        // Get top genre
        $topGenre = DB::table('movies')
            ->join('genres', 'movies.genre_id', '=', 'genres.id')
            ->select('genres.main_genre', DB::raw('count(*) as total'))
            ->groupBy('genres.main_genre')
            ->orderBy('total', 'desc')
            ->first();

        // Recent movies & suppliers count
        $recentMovies = Movies::where('created_at', '>=', now()->startOfMonth())->count();
        $suppliersCount = Supplier::count();

        // Most popular classification
        $topClassification = DB::table('movies')
            ->join('classifications', 'movies.classification_id', '=', 'classifications.id')
            ->select('classifications.code', DB::raw('count(*) as total'))
            ->groupBy('classifications.code')
            ->orderBy('total', 'desc')
            ->first();

        // Build query with filters
        $query = Movies::with(['genre', 'classification', 'supplier']);

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

        // Filter by classification
        if ($request->filled('classification_id')) {
            $query->where('classification_id', $request->classification_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Get the data with pagination
        $movies = $query->where('status', 'active')->orderBy('created_at', 'desc')->paginate(10);
        $genres = Genre::all();
        $classifications = Classification::all();
        $suppliers = Supplier::all();


            return response(
                view('Backend.Movies.index', compact(
                    'movies',
                    'genres',
                    'classifications',
                    'suppliers',
                    'totalMovies',
                    'activeMovies',
                    'inactiveMovies',
                    'topGenre',
                    'recentMovies',
                    'suppliersCount',
                    'topClassification'
                ))
            );
    }


    public function bookingCreate($movieId)
    {
            $movie = Movies::with(['showtimes'])->findOrFail($movieId);
            // Example: get all seats for the hall (replace with your actual seat logic)
            $seats = Seats::where('hall_id', $movie->hall_id ?? 1)->get();
            return view('Frontend.Booking.create', compact('movie', 'seats'));
    }

    public function home (){
        $movies = Movies::where('status', 'active')->get(); // or with any filters you want
        return view('Frontend.home', compact('movies'));
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
    //    dd($request->all());
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
            'trailer'           => 'nullable|string|max:500',
        ]);

        $PosterPath = null;
        if ($request->hasFile('poster')) {
            $PosterPath = $request->file('poster')->store('Poster', 'public');
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
            'trailer'           => $request->trailer, // Store URL directly

        ]);

        return redirect()->route('movies.index')->with('success', 'Movies created successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movies  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movies $movie)
    {
        //
        return view( 'Frontend.Movies.show', compact('movie'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movies  $movie
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|string
     */
public function edit(Movies $movie)
{
    // $movie = Movies::findOrFail($id);
    $genres = Genre::all();
    $suppliers = Supplier::all();
    $classifications = Classification::all();

    return view('Backend.Movies.edit', compact('movie', 'genres', 'suppliers', 'classifications'));
}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movies  $movie
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Movies $movie)
{
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
            'trailer'           => 'nullable|string|max:500',
        ]);
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $movie->poster = $request->file('poster')->store('Poster', 'public');
        }
        $result = $movie->update([
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
            'poster'            => $movie->poster,
            'trailer'           => $request->trailer,
        ]);
        $movie->save();

        return redirect()->route('movies.index')->with('success', 'Movies updated successfully!');
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
