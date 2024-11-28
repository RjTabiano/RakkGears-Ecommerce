<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Get the sales data, this can be fetched from your database
        $salesData = Order::selectRaw('SUM(total_price) as total, DATE(created_at) as date')
                        ->groupBy('date')
                        ->orderBy('date', 'asc')
                        ->take(30) // Fetch last 30 days (adjust as needed)
                        ->get();

        $salesDates = $salesData->pluck('date');
        $salesTotals = $salesData->pluck('total');
        $totalOrders = Order::count();
        $totalSales = Order::sum('total_price'); 
        $todaySales = Order::whereDate('created_at', today())->sum('total_price');

       
        return view('admin_panel.dashboard', [
            'salesDates' => $salesDates,
            'salesTotals' => $salesTotals,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'todaySales' => $todaySales,
        ]);
    }

}
