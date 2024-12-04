<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;


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


    public function accounts(Request $request)
    {
        $usertype = $request->query('usertype');

        $users = User::when($usertype, function ($query, $usertype) {
            $query->where('usertype', $usertype);
        })->paginate(10);

        return view('admin_panel.accounts', [
            'users' => $users,
            'usertype' => $usertype,
        ]);
    }


    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->usertype = 'admin';
        $user->save();

        return redirect()->route('accounts')->with('success', 'User has been updated to admin.');
    }

    public function makeUser($id)
    {
        $user = User::findOrFail($id);
        $user->usertype = 'user';
        $user->save();

        return redirect()->route('accounts')->with('success', 'User has been reverted to user.');
    }
}
