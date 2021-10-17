<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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
        return view('checkout');
    }
}
