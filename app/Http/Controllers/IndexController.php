<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $data = [];
        $data['hot_deals']  = Product::take(10)->limit(10)->get();
        $data['exclusives'] = Product::take(1)->limit(10)->get();
        return view('index', $data);
    }
}
