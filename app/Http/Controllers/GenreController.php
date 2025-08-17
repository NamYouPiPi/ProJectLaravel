<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Genre::query();

        // Search by name (main_genre or sub_genre)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('main_genre', 'LIKE', "%{$search}%")
                  ->orWhere('sub_genre', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by main genre category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('main_genre', $request->category);
        }

        // Get all distinct main genres for filter dropdown
        $categories = Genre::select('main_genre')
            ->distinct()
            ->orderBy('main_genre')
            ->pluck('main_genre');

        // Order by created_at desc and paginate
        $genres = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics for dashboard
        $totalGenres = Genre::count();
        $activeGenres = Genre::where('status', 'active')->count();
        $inactiveGenres = Genre::where('status', 'inactive')->count();

        return view('Backend.Genre.index', compact(
            'genres', 
            'categories', 
            'totalGenres', 
            'activeGenres', 
            'inactiveGenres'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('genre.create');
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
            'main_genre' => 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        Genre::create($data);
        return redirect()->route('genre.index')->with('success', 'Genre created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('Backend.Genre.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        //
        $data = $request->validate([
            'main_genre' => 'required|string|max:255',
            'sub_genre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $genre->update($data);
        return redirect()->route('genre.index', compact('success','Genre updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        //
        $genre->delete();
        return redirect()->route('genre.index')->with('success', 'Genre deleted successfully');;
    }
}
