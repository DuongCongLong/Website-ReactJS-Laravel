<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $newOrders = Order::whereDate('created_at', today())->count();
        $totalOrders = Order::count(); // Tổng số đơn hàng



    
        return view('backend.dashboard.index', compact('newOrders'));
    }    
}    
