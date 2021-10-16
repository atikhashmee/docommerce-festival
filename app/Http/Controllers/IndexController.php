<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
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
}
