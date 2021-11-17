<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Exports\DataExport;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Services\SendSMSService;
use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
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

        $data['serial'] = pagiSerial($data['orders'], 50);
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
            $order = Order::where('id', $data['order_id'])->first();
            $sms = "Thanks for ordering on DoCommerce 11-11 Festival 2021. Your order number is: ".strtotime($order->order_number).". Your products will be delivered within 72 hours. Happy Shopping!";
            $order->status = $data['status'];
            if ($order->save()) {
                if ($data['status'] == 'Confirmed') {
                    $sb = new SendSMSService($order->user->phone_number, $sms);
                    $sb->send();
                    OrderDetail::where('order_id', $data['order_id'])->update(['status' => 'In Progress']);
                }
                return response()->json(['status' => true, 'data'=> 'Successfully Updated']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }

    public function export() {
        return view('admin.orders.export');
    }

    public function exportSave(Request $request) {
        $data = $request->all();
        $data['columns'] = $request->columns == 'all' ? ['all'] : json_decode($data['columns']);
        $validator = Validator::make($data, [
            'columns' => 'required|array|in:all,order_id,date,customer,payment_method,product_source,status,amount',
            'from'    => 'required|date',
            'to'      => 'required|date',
            'format'  => 'required|in:xml,csv,json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if (in_array('all', $data['columns'])) {
                $data['columns'] = [
                    'order_id',
                    'date',
                    'customer',
                    'payment_method',
                    'amount',
                    'product_source',
                    'status',
                ];
            }

            $sql = Order::select('orders.*', "ODS.store_names");
            $sql->leftJoin(\DB::raw("(SELECT GROUP_CONCAT(stores.name) as store_names, order_id FROM order_details INNER JOIN stores ON stores.original_store_id = order_details.original_store_id  GROUP BY order_id) AS ODS"), "ODS.order_id", "=", "orders.id");
            $sql->whereBetween('orders.created_at', [$request->from, $request->to]);
            $orders = $sql->get();
            $columnsWiseData = [];
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $columnsData = [];
                    if (in_array('order_id', $data['columns'])) {
                        $columnsData['order_id'] = $order->order_number;
                    }
                    if (in_array('date', $data['columns'])) {
                        $columnsData['date'] = $order->created_at;
                    }
                    if (in_array('customer', $data['columns'])) {
                        $columnsData['customer'] = $order->user->name;
                    }
                    if (in_array('payment_method', $data['columns'])) {
                        $columnsData['payment_method'] = 'Cash-on';
                    }
                    if (in_array('amount', $data['columns'])) {
                        $columnsData['amount'] = $order->total_final_amount;
                    }
                    if (in_array('product_source', $data['columns'])) {
                        $columnsData['product_source'] = $order->store_names;
                    }
                    if (in_array('status', $data['columns'])) {
                        $columnsData['status'] = $order->status;
                    }
                    $columnsWiseData[] = $columnsData;
                }
            }
            if ($request->input('format') == 'json') {
                $filename = auth()->user()->store_id . "/exports/orders.json";
                Storage::disk('public')->put($filename, collect($columnsWiseData)->toJson(JSON_PRETTY_PRINT));
                $headers = array('Content-type' => 'application/json');
                return response()->download('storage/' . auth()->user()->store_id . '/exports/orders.json', 'orders.json', $headers);
            } elseif ($request->input('format') == 'xml') {
                $data = ArrayToXml::convert(['__numeric' => $orders->toArray()]);
                $filename = auth()->user()->store_id . "/exports/orders.xml";
                Storage::disk('public')->put($filename, $data);
                $headers = array('Content-type' => 'application/xml');
                return response()->download('storage/' . auth()->user()->store_id . '/exports/orders.xml', 'orders.xml', $headers);
            } else {
                return Excel::download(new DataExport(collect($columnsWiseData), $data['columns'], 'Orders'), 'orders.xlsx');
            }
            return redirect()->back()->withSuccess('Data exported');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
