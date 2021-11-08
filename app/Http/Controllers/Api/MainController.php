<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class MainController extends Controller
{
    public function getOrders(Request $request, $store_id)
    {
        $orders = Order::with('orderDetails', 'user', 'address')->select('orders.*')
        ->leftJoin("order_details", "order_details.order_id", "=", "orders.id")
        ->where("order_details.original_store_id", $store_id)
        ->get();
        return OrderResource::collection($orders);
    }
}
