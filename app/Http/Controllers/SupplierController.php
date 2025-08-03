<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->all());
        $search = $request->input('search');

        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->paginate(5);

        return view('supplier.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        //        dd($request->all());;
//        $data= $request->validate([
//            'name'=>"required|unique:suppliers,name",
//            'email'=>"required|email|unique:suppliers,email",
//            'phone'=>"required|string|max:20|unique:suppliers,phone",
//            'address'=>"required|string|max:255",
//            'contact_person'=>"required|string|max:255",
//            'supplier_type'=>"required|in:snacks,foods,drinks,others",
//            'status'=>"required|in:active,inactive",
//        ]);
        $data = $request->only([
            'name',
            'email',
            'phone',
            'address',
            'contact_person',
            'supplier_type',
            'status',
        ]);
        Supplier::create($data);
        // echo "hello world ";
//      Supplier::create($data);
     return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.Update', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|unique:suppliers,name,'.$supplier->id,
            'email' => 'required|email|unique:suppliers,email,'.$supplier->id,
            'phone' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index');
    }

}
