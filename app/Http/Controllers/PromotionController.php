<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::where('status', 'active')->paginate(10);
        return view('Backend.promotion.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Backend.promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Uncomment validation to ensure data integrity
        $request->validate([
            'description' => 'nullable|string',
            'proImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
        ]);

        try {
            $imageName = null;
            if ($request->hasFile('proImage')) {
                $imageName = $request->file('proImage')->store('promotion', 'public');
            } else {
                // If no file is uploaded despite validation, log this issue
                return redirect()->back()->with('error', 'Promotion image is required')->withInput();
            }

            // Make sure these field names match your database columns
            Promotion::create([
                'description' => $request->description,
                'proImage' => $imageName, // Ensure this column exists in your database
                'title' => $request->title,
                'status' => 'active',
            ]);

            return redirect()->back()->with('success', 'Promotion added successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Promotion creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add promotion: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        // Get all active promotions to display on the offers page
        $promotions = Promotion::where('status', 'active')->get();

        // Pass both the specific promotion and all promotions to the view
        return view('Frontend.offers', compact('promotions'));
    }

    /**
     * Display the offers page with all active promotions.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
        return view('Backend.promotion.create', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'description' => 'required|string',
            'promotion_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       $imagePath = $promotion->promotion_image;

            if($request->hasFile('promotion_image')){
                if($promotion->promotion_image){
                    Storage::disk('public')->delete($promotion->promotion_image);
                }
                $imagePath = $request->file('promotion_image')->store('promotions', 'public');
            }

        $promotion->update([
            'description' => $request->description,
            'promotion_image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Promotion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
                 if ($promotion->promotion_image && Storage::disk('public')->exists($promotion->promotion_image)) {
            Storage::disk('public')->delete($promotion->promotion_image);
        }
            $promotion->status = 'inactive';
            $promotion->save();
            return redirect()->back()->with('success', 'Promotion deleted successfully.');
    }
}
