<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
//        $Inventories = Inventory::paginate(10);
            $inventories = Inventory::select('inventories.*', 'suppliers.name as supplier_name')
                ->join('suppliers', 'suppliers.id', '=', 'inventories.supplier_id')->paginate(10);
        $Suppliers = Supplier::all(); // Get all suppliers for the dropdown
        $category = Inventory::select('category')->distinct()->get();
        return view('Backend.inventory.index', compact('inventories' ,'Suppliers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        $Suppliers = Supplier::all();
        return view('Backend.inventory.create');
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
        try {
            $request->validate([
                'item_name'     => 'required|string|max:255',
                'supplier_id'   => 'required|integer',
                'quantity'      => 'required|integer',
                'category'      => 'required|string|max:255',
                'unit'          =>'required|string|max:255',
                'stock'         =>'required|in:in_stock,out_of_stock',
                'stock_level'   =>'required|integer',
                'reorder_level' =>'required|integer',
                'cost_price'    =>'required|numeric',
                'sale_price'    =>'required|numeric',
                'status'        =>'required|in:active,inactive',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- changed here
            ]);
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('Inventory', 'public');
            }
            Inventory::create([
                'item_name'         => $request->item_name,
                'supplier_id'       => $request->supplier_id,
                'quantity'          => $request->quantity,
                'category'          => $request->category,
                'unit'              => $request->unit,
                'stock'             => $request->stock,
                'stock_level'       => $request->stock_level,
                'reorder_level'     => $request->reorder_level,
                'cost_price'        => $request->cost_price,
                'sale_price'        => $request->sale_price,
                'status'            => $request->status,
                'image'             => $imagePath,
            ]);

            return redirect()->route('inventory.index')->with('success', 'Inventory created successfully!');

        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
        //  Inventory::all();
        // return view('inventory.show' , compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
          Inventory::all();
        $suppliers = Supplier::all(); // Get all suppliers for the dropdown
        return view('Backend.Inventory.edit', compact('inventory', 'suppliers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        try {
            $request->validate([
                'item_name'     => 'required|string|max:255',
                'supplier_id'   => 'required|integer',
                'quantity'      => 'required|integer',
                'category'      => 'required|string|max:255',
                'unit'          =>'required|string|max:255',
                'stock'         =>'required|in:in_stock,out_of_stock',
                'stock_level'   =>'required|integer',
                'reorder_level' =>'required|integer',
                'cost_price'    =>'required|numeric',
                'sale_price'    =>'required|numeric',
                'status'        =>'required|in:active,inactive',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- changed here
            ]);
             $imagePath = $inventory->image;

            if($request->hasFile('image')){
                if($inventory->image){
                    Storage::disk('public')->delete($inventory->image);
                }
                $imagePath = $request->file('image')->store('Inventory', 'public');
            }

            $inventory->update([
                'item_name'     => $request->item_name,
                'supplier_id'   => $request->supplier_id,
                'quantity'      => $request->quantity,
                'category'      => $request->category,
                'unit'          =>$request->unit,
                'stock'         =>$request->stock,
                'stock_level'   =>$request->stock_level,
                'reorder_level' =>$request->reorder_level,
                'cost_price'    =>$request->cost_price,
                'sale_price'    =>$request->sale_price,
                'status'        =>$request->status,
                'image'         => $imagePath
            ]);
            return redirect()->route('inventory.index')
                ->with('success', 'Inventory updated successfully!');

            }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
            Storage::disk('public')->delete($inventory->image);
        }

            return redirect()->route('inventory.index')
                ->with('success', 'Inventory deleted successfully!');
    }

    public  function  restock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);
        $item = Inventory::findOrFail($id);
         $item->stock_level + $request->quantity;
        $item->save();
        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully!');
    }
    public  function filterbycategory($category)
    {
        $item = Inventory::where('category', $category)->get();
        return view('inventory.index', compact('item'));
    }
    public  function  lowStock()
    {
        $item = Inventory::whereColumn('stock_level', '<', 'reorder_level')->get();
        return view('Backend.Inventory.index', compact('item'));
    }

}
