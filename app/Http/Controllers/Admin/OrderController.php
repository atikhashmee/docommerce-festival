<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request) {
        $data = [];
        $orders = Order::select('orders.*')->with(['orderDetails', 'orderDetails.store'])
        ->paginate(50);
        $data['orders'] = $orders;
        return view('admin.orders.index', $data);
    }

    public function show($id) {
        $data = [];
        $order = Order::select('orders.*')->with(['orderDetails', 'orderDetails.store', 'address' => function($q){
            $q->select('order_addresses.*', 'global_states.name as state_name', 'global_districts.name as district_name');
            $q->leftJoin('global_states', 'global_states.id', '=', 'order_addresses.state_id');
            $q->leftJoin('global_districts', 'global_districts.id', '=', 'order_addresses.district_id');
        }])
        ->where('orders.id', $id)
        ->first();
        $data['order'] = $order;
        return view('admin.orders.show', $data);
    }

    public function changeStatus($order_id) {
        $data = [];
        $order = Order::select('orders.*')->with(['orderDetails', 'orderDetails.store', 'address' => function($q){
            $q->select('order_addresses.*', 'global_states.name as state_name', 'global_districts.name as district_name');
            $q->leftJoin('global_states', 'global_states.id', '=', 'order_addresses.state_id');
            $q->leftJoin('global_districts', 'global_districts.id', '=', 'order_addresses.district_id');
        }])
        ->where('orders.id', $order_id)
        ->first();
        $data['order'] = $order;
        return view('admin.orders.change-status', $data);
    }

    public function updateOrderStatus(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'status' => 'required',
            'detail_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data'=> $validator->errors()]);
        }
        
        try {
            $updated = OrderDetail::where('id', $data['detail_id'])->update(['status' => $data['status']]);
            if ($updated) {
                return response()->json(['status' => true, 'data'=> 'Successfully Updated']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }
    public function updateOrderChange(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'status' => 'required',
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data'=> $validator->errors()]);
        }

        try {
            $updated = Order::where('id', $data['order_id'])->update(['status' => $data['status']]);
            if ($updated) {
                return response()->json(['status' => true, 'data'=> 'Successfully Updated']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }
}
