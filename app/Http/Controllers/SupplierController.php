<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_suppliers')->only(['index', 'show']);
        $this->middleware('permission:create_suppliers')->only(['create', 'store']);
        $this->middleware('permission:edit_suppliers')->only(['edit', 'update']);
        $this->middleware('permission:delete_suppliers')->only(['destroy']);
    }

    public function index(Request $request)
        {
            $searchStatus = $request->input('status'); // Get status from the filter
            $search = $request->input('search'); // If you have a search input

            $query = Supplier::query();

            // Filter by status if selected
            if ($searchStatus) {
                $query->where('status', $searchStatus);
            }

            // Optional: filter by search term
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
                });
            }
            $suppliers = $query->paginate(10);

            return view('Backend.supplier.index', compact('suppliers', 'searchStatus', 'search'));
        }

    public function create()
    {
        return view('Backend.supplier.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'           => 'required|string|max:255',
                'email'          => 'required|email|unique:suppliers,email',
                'phone'          => 'nullable|string|max:20',
                'contact_person' => 'nullable|string|max:255',
                'supplier_type'  => 'required|in:foods,drinks,snacks,others,movies',
                'status'         => 'required|in:active,inactive',
                'address'        => 'nullable|string|max:500',
            ]);

            $supplier = Supplier::create($validatedData);

            if ($request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Supplier created successfully!',
                    'supplier' => $supplier
                ]);
            }

            return redirect()->route('admin.suppliers.index')
                ->with('success', 'Supplier created successfully!');
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()

            ]);
        }
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

    //    dd($request->all());
            $validatedData = $request->validate([
                'name'              => 'required|string|max:255',
                'email'             => 'required|email|unique:suppliers,email,' . $supplier->id,
                'phone'              => 'nullable|string|max:20',
                'contact_person'     => 'nullable|string|max:255',
                'supplier_type'      => 'required|string|max:255',
                'status'             => 'required|in:active,inactive',
                'address'            => 'nullable|string|max:500',
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
        $supplier->status = 'inactive';
        $supplier->save();

    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Supplier status set to inactive!'
        ]);
    }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier status set to inactive!');
    }
}
