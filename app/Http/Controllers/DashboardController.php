<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->roles[0]->name == 'user') {
            $user = User::where('id', Auth::user()->id)
                ->with('address')
                ->first();
            return view('frontend.user.dashboard', compact('user'));
        } else if (Auth::user()->roles[0]->name == 'superadmin') {
            $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
            $dashboardData = DB::select("
            SELECT 
                SUM(CAST(REPLACE(total, ',', '') AS DECIMAL(10, 2))) AS TotalAmount,
                SUM(IF(status = 'ordered', CAST(REPLACE(total, ',', '') AS DECIMAL(10, 2)), 0)) AS TotalOrderedAmount,
                SUM(IF(status = 'delivered', CAST(REPLACE(total, ',', '') AS DECIMAL(10, 2)), 0)) AS TotalDeliveredAmount,
                SUM(IF(status = 'canceled', CAST(REPLACE(total, ',', '') AS DECIMAL(10, 2)), 0)) AS TotalCanceledAmount,
                COUNT(*) AS Total,
                COUNT(IF(status = 'ordered', 1, NULL)) AS TotalOrdered,
                COUNT(IF(status = 'delivered', 1, NULL)) AS TotalDelivered,
                COUNT(IF(status = 'canceled', 1, NULL)) AS TotalCanceled
            FROM Orders
        ");


            $monthlyData = DB::select("
                                        SELECT 
                                            M.id AS MonthNo, 
                                            M.name AS MonthName,
                                            IFNULL(D.TotalAmount, 0) AS TotalAmount,
                                            IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount, 
                                            IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                                            IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount 
                                        FROM month_names M
                                        LEFT JOIN (
                                            SELECT 
                                                DATE_FORMAT(created_at, '%b') AS MonthName,
                                                MONTH(created_at) AS MonthNo,
                                                SUM(total) AS TotalAmount,
                                                SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                                                SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                                                SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount
                                            FROM Orders 
                                            WHERE YEAR(created_at) = YEAR(NOW()) 
                                            GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                                            ORDER BY MONTH(created_at)
                                        ) D ON D.MonthNo = M.id
                                    ");
            $AmountM = implode(',', collect($monthlyData)->pluck('TotalAmount')->toArray());
            $OrderedAmountM = implode(',', collect($monthlyData)->pluck('TotalOrderedAmount')->toArray());
            $DeliveredAmountM = implode(',', collect($monthlyData)->pluck('TotalDeliveredAmount')->toArray());
            $CanceledAmountM = implode(',', collect($monthlyData)->pluck('TotalCanceledAmount')->toArray());

            $TotalAmount = collect($monthlyData)->sum('TotalAmount');
            $TotalOrderedAmount = collect($monthlyData)->sum('TotalOrderedAmount');
            $TotalDeliveredAmount = collect($monthlyData)->sum('TotalDeliveredAmount');
            $TotalCanceledAmount = collect($monthlyData)->sum('TotalCanceledAmount');

            return view('backend.dashboard', compact(
                'orders',
                'dashboardData',
                'monthlyData',
                'AmountM',
                'OrderedAmountM',
                'DeliveredAmountM',
                'CanceledAmountM',
                'TotalAmount',
                'TotalOrderedAmount',
                'TotalDeliveredAmount',
                'TotalCanceledAmount'
            ));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($products);
    }
}
