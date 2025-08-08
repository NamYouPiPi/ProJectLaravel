<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('Backend.supplier.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('Backend.supplier.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'supplier_type' => 'required|in:foods,drinks,snacks,others',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::create($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully!',
                'supplier' => $supplier
            ]);
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    public function show(Supplier $supplier)
    {
//        return view('Backend.supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        // If it's an AJAX request, return only the form partial
        if (request()->ajax()) {
            return view('Backend.supplier.edit', compact('supplier'))->render();
        }

        return view('Backend.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {

//        dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
                'phone' => 'nullable|string|max:20',
                'contact_person' => 'nullable|string|max:255',
                'supplier_type' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                'address' => 'nullable|string|max:500',
            ]);
            // $supplier->update($validatedData);
            $supplier->update($validatedData);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Supplier updated successfully!',
                    'supplier' => $supplier->fresh()
                ]);}

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully!'
            ]);
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
