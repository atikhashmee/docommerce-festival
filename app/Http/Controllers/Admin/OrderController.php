<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) {
        $data = [];
        $orders = Order::select('orders.*')->with(['orderDetails', 'orderDetails.store'])
        ->paginate(50);
        $data['orders'] = $orders;
        return view('admin.orders.index', $data);
    }
}
