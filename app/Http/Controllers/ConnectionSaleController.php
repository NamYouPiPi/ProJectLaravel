<?php

namespace App\Http\Controllers;

use App\Models\connection_sale;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class ConnectionSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        //\
        $sales = connection_sale::query()
            ->select('connection_sales.*', 'inventories.item_name as item_name') // change to your real column
            ->join('inventories', 'inventories.id', '=', 'connection_sales.inventory_id')
            ->paginate(20);
        $inventories = Inventory::all();
        return view('Backend.ConnectionSale.index', compact('sales' , 'inventories') );
    }

    public function generateReport(Request $request)
    {
        // Get filter parameters
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $inventoryId = $request->get('inventory_id');

        // Build query with filters
        $query = connection_sale::with('inventory');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($inventoryId) {
            $query->where('inventory_id', $inventoryId);
        }

        $sales = $query->get();

        // Calculate totals
        $totalQuantity = $sales->sum('quantity');
        $totalRevenue = $sales->sum('total_price');

        $data = [
            'sales' => $sales,
            'totalQuantity' => $totalQuantity,
            'totalRevenue' => $totalRevenue,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now()
        ];

        // Return as PDF download
        $pdf = PDF::loadView('Backend.ConnectionSale.report', $data);
        return $pdf->download('connection-sales-report-' . now()->format('Y-m-d') . '.pdf');

        // OR return as HTML view
        // return view('Backend.ConnectionSale.report', $data);
    }
    public function bestSellers(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $limit = $request->get('limit', 10); // Default top 10

        $query = connection_sale::query()
            ->select('inventory_id',
                \DB::raw('SUM(quantity) as total_quantity'),
                \DB::raw('SUM(total_price) as total_revenue'),
                \DB::raw('COUNT(*) as total_orders'))
            ->with('inventory:id,item_name');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $bestSellers = $query->groupBy('inventory_id')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();

        $data = [
            'bestSellers' => $bestSellers,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'limit' => $limit,
            'generatedAt' => now()
        ];

        // Return as PDF
        if ($request->get('format') === 'pdf') {
            $pdf = PDF::loadView('Backend.ConnectionSale.best-sellers-report', $data);
            return $pdf->download('best-sellers-report-' . now()->format('Y-m-d') . '.pdf');
        }

        // Return as HTML view
        return view('Backend.ConnectionSale.best-sellers-report', $data);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

            $inventories = Inventory::all();

        return view('Backend.ConnectionSale.create', compact('inventories'));
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
        $request ->validate([
            'quantity.*'=>'required|integer',
            'price.*'=>'required|numeric',
            'inventory_id.*'=>'required|exists:inventories,id',
        ]);
        $data = [];
        foreach ($request->quantity as $item =>$quantity){
            $data[]= [
                'quantity'=>$quantity,
                'price'=>$request->price[$item],
                'inventory_id'=>$request->inventory_id[$item],
                'created_at'=>now(),
                'updated_at'=>now(),
                'total_price'=>$request->price[$item]*$request->quantity[$item],
            ];
        }

        \DB::table('connection_sales')->insert($data);

//        connection_sale::created($request->all());

        return redirect()->route('sale.index')->with('success', 'Connection Sale created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function show(connection_sale $connection_sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function edit(connection_sale $connection_sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, connection_sale $connection_sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(connection_sale $connection_sale)
    {
        //
    }
}
