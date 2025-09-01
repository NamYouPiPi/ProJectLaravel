<?php

namespace App\Http\Controllers;

use App\Models\connection_sale;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ConnectionSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_connection_sales')->only(['index', 'show', 'analytics', 'monthlyReport', 'chartData', 'generateReport', 'bestSellers']);
        $this->middleware('permission:create_connection_sales')->only(['create', 'store']);
        $this->middleware('permission:edit_connection_sales')->only(['edit', 'update']);
        $this->middleware('permission:delete_connection_sales')->only(['destroy']);
    }
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
            ->paginate(10);
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
    public function edit(connection_sale $sale)
    {
        $connection_sale = $sale; // Keep compatibility with existing form
        $inventories = Inventory::all();

        if (request()->ajax()) {
            return view('Backend.ConnectionSale.edit', compact('connection_sale', 'inventories'))->render();
        }

        return view('Backend.ConnectionSale.edit', compact('connection_sale', 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, connection_sale $sale)
    {
        $connection_sale = $sale; // Keep compatibility

        $request->validate([
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
            'inventory_id.*' => 'required|exists:inventories,id',
        ]);

        // For single sale update (since your form shows single item)
        $connection_sale->update([
            'quantity' => $request->quantity[0],
            'price' => $request->price[0],
            'inventory_id' => $request->inventory_id[0],
            'total_price' => $request->price[0] * $request->quantity[0],
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Sale updated successfully!']);
        }

        return redirect()->route('sale.index')->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\connection_sale  $connection_sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(connection_sale $sale)
    {
        $connection_sale = $sale; // Keep compatibility
        $connection_sale->delete();

        return redirect()->route('sale.index')->with('success', 'Sale deleted successfully!');
    }

    /**
     * Get sales analytics dashboard
     */
    public function analytics()
    {
        // Test with simple dummy data to isolate the issue
        $currentMonth = Carbon::now();

        return view('Backend.ConnectionSale.analytics', [
            'currentMonthSales' => 1500.00,
            'previousMonthSales' => 1200.00,
            'currentYearSales' => 18000.00,
            'monthlySales' => collect([
                (object)['month' => 1, 'total' => 1000],
                (object)['month' => 2, 'total' => 1500],
                (object)['month' => 3, 'total' => 1200]
            ]),
            'yearlySales' => collect([
                (object)['year' => 2023, 'total' => 15000],
                (object)['year' => 2024, 'total' => 18000]
            ]),
            'topSellingItems' => collect([
                (object)['item_name' => 'Popcorn', 'total_quantity' => 50, 'total_revenue' => 500],
                (object)['item_name' => 'Soda', 'total_quantity' => 30, 'total_revenue' => 300],
            ]),
            'dailySales' => collect([
                (object)['day' => 1, 'total' => 100],
                (object)['day' => 2, 'total' => 150],
                (object)['day' => 3, 'total' => 200]
            ]),
            'currentMonth' => $currentMonth
        ]);
    }

    /**
     * Get monthly sales report
     */
    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $salesData = connection_sale::select(
                'connection_sales.*',
                'inventories.item_name'
            )
            ->join('inventories', 'inventories.id', '=', 'connection_sales.inventory_id')
            ->whereMonth('connection_sales.created_at', $month)
            ->whereYear('connection_sales.created_at', $year)
            ->orderBy('connection_sales.created_at', 'desc')
            ->get();

        $totalSales = $salesData->sum('total_price');
        $totalQuantity = $salesData->sum('quantity');

        return response()->json([
            'sales_data' => $salesData,
            'total_sales' => $totalSales,
            'total_quantity' => $totalQuantity,
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * Get sales chart data
     */
    public function chartData(Request $request)
    {
        $type = $request->get('type', 'monthly'); // monthly, yearly, daily
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        switch($type) {
            case 'daily':
                $data = connection_sale::select(
                        DB::raw('DAY(created_at) as period'),
                        DB::raw('SUM(total_price) as total')
                    )
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->groupBy(DB::raw('DAY(created_at)'))
                    ->orderBy('period')
                    ->get();
                break;

            case 'yearly':
                $data = connection_sale::select(
                        DB::raw('YEAR(created_at) as period'),
                        DB::raw('SUM(total_price) as total')
                    )
                    ->where('created_at', '>=', Carbon::now()->subYears(5))
                    ->groupBy(DB::raw('YEAR(created_at)'))
                    ->orderBy('period')
                    ->get();
                break;

            default: // monthly
                $data = connection_sale::select(
                        DB::raw('MONTH(created_at) as period'),
                        DB::raw('SUM(total_price) as total')
                    )
                    ->whereYear('created_at', $year)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->orderBy('period')
                    ->get();
                break;
        }

        return response()->json($data);
    }
}
