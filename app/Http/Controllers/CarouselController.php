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
        // Not used, handled in PromotionController@index
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '_' . $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->storeAs('public/promotions', $imageName);

        Carousel::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imageName,
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($carousel->image_path && Storage::exists('public/promotions/' . $carousel->image_path)) {
                Storage::delete('public/promotions/' . $carousel->image_path);
            }
            $imageName = time() . '_' . $request->file('image_path')->getClientOriginalName();
            $request->file('image_path')->storeAs('public/promotions', $imageName);
            $data['image_path'] = $imageName;
        }

        $carousel->update($data);

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
        if ($carousel->image_path && Storage::exists('public/promotions/' . $carousel->image_path)) {
            Storage::delete('public/promotions/' . $carousel->image_path);
        }
        $carousel->delete();
        return redirect()->back()->with('success', 'Carousel image deleted successfully.');
    }
}
