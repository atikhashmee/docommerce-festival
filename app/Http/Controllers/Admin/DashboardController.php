<?php

namespace App\Http\Controllers\Admin;

use App\Models\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;

class DashboardController extends Controller
{
    public function index() {
       return redirect(route('admin.login'));
    }

    public function dashboard() {
        $data = [];
        $today = date('Y-m-d');
        $data['total_orders']       = Order::count();
        $data['today_total_orders'] = Order::whereDate('created_at', $today)->count();
        $data['total_sales']        = Order::sum('total_final_amount');
        $data['today_total_sales']  = Order::whereDate('created_at', $today)->sum('total_final_amount');
        $data['pending_orders']     = Order::where('status', 'Pending')->count();
        $data['top_five_products']  = Product::select('products.*', 'P.total_freq')
                                        ->with('store')
                                        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_freq, product_id FROM order_details GROUP BY product_id) as P'), 'P.product_id', '=', 'products.id')
                                        ->orderBy('P.total_freq', 'DESC')
                                        ->whereNotNull('P.total_freq')
                                        ->limit(5)
                                        ->get(); 
        $data['top_five_stores'] = Store::select('stores.*', 'O.total_orders')
                                        ->leftJoin(\DB::raw("(SELECT count(DISTINCT order_details.order_id) as total_orders, original_store_id FROM order_details GROUP BY original_store_id) AS O"), 'O.original_store_id', '=', 'stores.original_store_id')
                                        ->orderBy('O.total_orders', 'DESC')
                                        ->whereNotNull('O.total_orders')
                                        ->limit(5)
                                        ->get();
        return view('admin.dashboard', $data);
    }

    public function setFestival(Request $request) {
        $data = [];
        $today = date('Y-m-d h:i:s');
        $data['festivals'] = Festival::select('*')
        // ->whereDate('festivals.start_at','<=', $today)
        // ->whereDate('festivals.end_at','>=', $today)
        ->get();
        return view('admin.set-festival', $data);
    }

    public function postFestival(Request $request) {
        Admin::whereNotNull('id')->update(['festival_id' => $request->festival_id]);
        return redirect()->back()->withSuccess('Festival has been set');
    }
}
