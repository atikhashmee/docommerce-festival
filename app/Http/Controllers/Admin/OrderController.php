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
        $sql = Order::select('orders.*', "ODS.store_names");
        $sql->leftJoin(\DB::raw("(SELECT GROUP_CONCAT(stores.name) as store_names, order_id FROM order_details INNER JOIN stores ON stores.original_store_id = order_details.original_store_id  GROUP BY order_id) AS ODS"), "ODS.order_id", "=", "orders.id");
        if (isset($request->search_key)) {
            $sql->where('orders.id', 'LIKE', '%' . $request->search_key . '%');
            // $sql->orWhere('products.id', 'LIKE', '%' . $request->search_key . '%');
        }
        if (isset($request->status) && $request->status != 'all') {
            $sql->where('orders.status', 'LIKE', $request->status);
        }
        if (isset($request->from)) {
            $sql->whereDate('orders.created_at', '>=', $request->from);
        }
        if (isset($request->to)) {
            $sql->whereDate('orders.created_at', '<=', $request->to);
        }
        $sql->orderBy("id", "DESC");
        $data['orders'] = $sql->paginate(50);
        return view('admin.orders.index', $data);
    }

    public function show($id) {
        $data = [];
        $order = Order::select('orders.*')->with(['orderDetails', 'orderDetails.store', 'address' => function($q){
            $q->select('order_addresses.*', 'global_states.name as state_name', 'global_districts.name as district_name');
            $q->leftJoin('global_states', 'global_states.id', '=', 'order_addresses.state_id');
            $q->leftJoin('global_districts', 'global_districts.id', '=', 'order_addresses.district_id');
        }]);
        $order->leftJoin(\DB::raw("(SELECT GROUP_CONCAT(stores.name) as store_names, GROUP_CONCAT(stores.store_address) as store_address, order_id FROM order_details INNER JOIN stores ON stores.original_store_id = order_details.original_store_id  GROUP BY order_id) AS ODS"), "ODS.order_id", "=", "orders.id");
        $order->where('orders.id', $id)
        ->first();
        $data['order'] = $order;
        return view('admin.orders.show', $data);
    }

    public function changeStatus($order_id) {
        $data = [];
        $order = Order::select('orders.*', "ODS.store_info")->with(['orderDetails', 'orderDetails.store', 'address' => function($q){
            $q->select('order_addresses.*', 'global_states.name as state_name', 'global_districts.name as district_name');
            $q->leftJoin('global_states', 'global_states.id', '=', 'order_addresses.state_id');
            $q->leftJoin('global_districts', 'global_districts.id', '=', 'order_addresses.district_id');
        }]);
        $order->leftJoin(\DB::raw("(SELECT GROUP_CONCAT(DISTINCT CONCAT(stores.name,'|',stores.store_address) SEPARATOR ';') as store_info, order_id FROM order_details INNER JOIN stores ON stores.original_store_id = order_details.original_store_id GROUP BY order_id) AS ODS"), "ODS.order_id", "=", "orders.id");
        $data['order'] = $order->where('orders.id', $order_id)->first();
        $data['stores'] = array_map(function($q) {
            list($store_name, $address)  = explode('|', $q);
            return [$store_name, json_decode($address, true)];
        }, explode(';', $data['order']->store_info));
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
                if ($data['status'] == 'Confirmed') {
                    OrderDetail::where('order_id', $data['order_id'])->update(['status' => 'In Progress']);
                }
                return response()->json(['status' => true, 'data'=> 'Successfully Updated']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }
}
