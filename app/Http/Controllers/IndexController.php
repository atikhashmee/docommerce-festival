<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index() {
        $data = [];
        $data['stores']  = Store::join('store_festivals', 'store_festivals.store_id', '=', 'stores.id')
        ->where('store_festivals.festival_id', 1)->get();
        $data['hot_deals']  = Product::take(10)->limit(10)->get();
        $data['exclusives'] = Product::take(1)->limit(10)->get();
        return view('index', $data);
    }

    public function storeData($store_id)
    {
        $data = [];
        $data['exclusives'] = Product::where('store_id', $store_id)->where('festival_id', 1)->take(1)->limit(10)->get();        
        $data['categories']  = Category::select('categories.*', 'TP.total_products')->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) TP'), 'TP.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', 1)->get();
        return view('products', $data);
    }

    public function categoryData($category_id) {
        $data = [];
        $data['exclusives'] = Product::where('category_id', $category_id)->where('festival_id', 1)->take(1)->limit(10)->get();        
        $data['categories']  = Category::select('categories.*', 'TP.total_products')->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) TP'), 'TP.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', 1)->get();
        return view('products', $data);
    }

    public function cartView() {
        return view('cart_view');
    }

    public function checkout() {
        $data = [];
        $data['states'] = \DB::table('global_states')->where('country_id', 19)->get();
        $data['districts'] = \DB::table('global_districts')->whereIn('global_state_id', $data['states']->map(function($item){return $item->id;})->toArray())->get();
        return view('checkout', $data);
    }

    public function placeOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            'address_line_1' => 'required',
            'zip_code' => 'required',
            'phone' => 'required',
            'payment_option' => 'required|in:cash_on',
        ]);
        $cartItems = json_decode($request->items, true);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        if (count($cartItems) == 0) {
            return response()->json(['status' => false, 'error' => 'Cart is empty']);
        }

        try {
            \DB::beginTransaction();
            dd($request->all());
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }

    }
}
