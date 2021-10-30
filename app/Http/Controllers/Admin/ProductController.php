<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Product;
use App\Models\Festival;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data  = [];
        $data['stores'] = Store::get();
        $data['categories'] = Category::get(); 
        $productSql = Product::select('*');
        $productSql->where(function($q) use($request) {
            if ($request->category_id) {
                $q->where('category_id', $request->category_id);
            }

            if ($request->store_id) {
                $q->where('store_id', $request->store_id);
            }

            if ($request->search) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            }
        });
        $data['products'] = $productSql->get();
        return view('admin.products.index', $data);
    }

    public function import(Request $request) {
        $data  = [];
        $data['festivals'] = Festival::get(); 
        $data['categories'] = Category::get(); 
        $data['products'] = []; 
        $productCollect = new Collection();
        if ($request->store_id) {
            $response = Http::get(env("REMOTE_BASE_URL").'/api/festival/get-products/'.$request->store_id);
            if ($response->ok()) {
                $items = $response;
                if (count($items['data']) > 0) {
                    foreach ($items['data'] as $item) {
                        $collecItem = new Product($item);
                        if (count($item['variants']) > 0) {
                            $collecItem->variants = $item['variants'];
                            dd($productCollect, $collecItem);
                        }
                        $productCollect->push($collecItem);
                    }
                    
                }
            }
            if (count($productCollect) > 0) {
                $data['products'] = $productCollect;
            }
        }
        return view('admin.products.import', $data);
    }
}
