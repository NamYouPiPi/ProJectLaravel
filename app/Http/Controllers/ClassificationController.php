<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_classifications')->only(['index', 'show']);
        $this->middleware('permission:create_classifications')->only(['create', 'store']);
        $this->middleware('permission:edit_classifications')->only(['edit', 'update']);
        $this->middleware('permission:delete_classifications')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $classifications = Classification::where('status', 'active')->paginate(10);
        return view('Backend.Classification.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Backend.Classification.create');
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
                'code'=>'required|string|max:255',
                'name'=>'required|string|max:255',
                'age_limit'=>'required|integer',
                'description'=>'required|string|max:255',
                'country'=>'required|string|max:255',
                'status'=>'required|in:active,inactive',
            ]);
            Classification::create($data);
            return redirect()->route('classification.index')->with('success', 'Classification created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function show(Classification $classification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function edit(Classification $classification)
    {
        //
        return view('Backend.Classification.edit', compact('classification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classification $classification)
    {
        //
        $data =$request->validate([
            'code'=>'required|string|max:255',
            'name'=>'required|string|max:255',
            'age_limit'=>'required|integer',
            'description'=>'required|string|max:255',
            'country'=>'required|string|max:255',
            'status'=>'required|in:active,inactive',
        ]);
        $classification->update($data);
        return redirect()->route('classification.index')->with('success', 'Classification updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classification $classification)
    {
        //
        // $classification->delete();
        $classification->status = 'inactive';
        $classification->save();
        return redirect()->route('classification.index')->with('success', 'Classification deleted successfully!');
    }
}
