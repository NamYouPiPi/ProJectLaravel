<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels = Carousel::paginate(10);
    return view('Backend.carousel.index', compact('carousels'));
    }

   

    /**
     * Show the form for creating a new resource.
    *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Backend.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'carouselImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
            if ($request->hasFile('carouselImage')) {
                $imageName = $request->file('carouselImage')->store('carousels', 'public');
            }

            Carousel::create([
                'carousel_image' => $imageName, // Ensure this column exists in your database
                'status' => 'active',
            ]);

        return redirect()->back()->with('success', 'Carousel image added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function show(Carousel $carousel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function edit(Carousel $carousel)
    {
        //
        return view('Backend.carousel.create', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carousel $carousel)
    {
        $request->validate([
            'carouselImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $carousel->carousel_image;

            if($request->hasFile('carouselImage')){
                if($carousel->carousel_image){
                    Storage::disk('public')->delete($carousel->carousel_image);
                }
                $imagePath = $request->file('carouselImage')->store('carousels', 'public');
            }
        $carousel->update([
            'carousel_image' => $imagePath,
        ]);
        return redirect()->back()->with('success', 'Carousel image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carousel $carousel)
    {
        $carousel->status = 'inactive';
        $carousel->save();
        return redirect()->back()->with('success', 'Carousel image deleted successfully.');
    }
}
