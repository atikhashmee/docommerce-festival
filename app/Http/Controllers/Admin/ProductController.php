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
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
       
        return view('admin.products.import', $data);
    }
    public function storeProduct($store_id) {
        $productCollect = [];
        if ($store_id) {
            $response = Http::get(env("REMOTE_BASE_URL").'/api/festival/get-products/'.$store_id);
            if ($response->ok()) {
                $items = $response;
                if (count($items['data']) > 0) {
                    foreach ($items['data'] as $item) {
                        $item['percentage'] = 0;
                        $item['fixed'] = 0;
                        $item['new_price'] = 0;
                        $item['category_id'] = "";
                        if (count($item['variants']) > 0) {
                            foreach ($item['variants'] as &$variant) {
                                $variant['percentage'] = 0;
                                $variant['fixed'] = 0;
                                $variant['new_price'] = 0;
                            }
                        }
                        array_push($productCollect, $item);
                    }
                }
            }

            if (count($productCollect) > 0) {
                $data['products'] = $productCollect;
            }
        }
        return $productCollect;
    }

    public function importStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'festival_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data'=> $validator->errors()]);
        }

        try {
            \DB::beginTransaction();
            $items = json_decode($request->products, true);
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    if ($item['category_id'] != null) {
                        $product = Product::updateOrCreate([
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'festival_id' => $request->festival_id
                        ], [
                            'category_id' => $item['category_id'],
                            'store_id' => $request->store_id,
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'name' => $item['name'],
                            'section_type' => 'hot_deals',
                            'original_product_url' => $item['original_product_url'],
                            'discount_type' => $item['percentage'] == 0 ? 'fixed' : 'percentage',
                            'discount_amount' => $item['percentage'] == 0 ?  $item['fixed'] : $item['percentage'],
                            'slug' => $item['slug'],
                            'short_description' => $item['short_description'],
                            'admin_id' => $item['admin_id'],
                            'price' => $item['price'],
                            'old_price' => $item['old_price'] ?? 0,
                            'original_product_img' => $item['original_product_img'],
                            'is_feature' => $item['is_feature'],
                            'is_new_arrival' => $item['is_new_arrival'],
                            'page_title' => $item['page_title'],
                            'meta_keyword'=> $item['meta_keyword'],
                            'meta_description' => $item['meta_description'],
                            'visit_count' => $item['visit_count'],
                        ]);
                        if (count($item['variants']) > 0) {
                            foreach ($item['variants'] as $variant) {
                                ProductVariant::updateOrCreate([
                                    'store_id' => $item['original_store_id'],
                                    'product_id' => $product->id,
                                    'festival_id' => $request->festival_id
                                ], [
                                    'product_id' => $product->id,
                                    'festival_id' => $request->festival_id,
                                    'store_id' => $request->store_id,
                                    'name' => $variant['name'],
                                    'discount_type' => $variant['percentage'] == 0 ? 'fixed' : 'percentage',
                                    'discount_amount' => $variant['percentage'] == 0 ?  $variant['fixed'] : $variant['percentage'],
                                    'opt1_name' => $variant['opt1_name'],
                                    'opt2_name' => $variant['opt2_name'],
                                    'opt3_name' => $variant['opt3_name'],
                                    'opt1_value' => $variant['opt1_value'],
                                    'opt2_value' => $variant['opt2_value'],
                                    'opt3_value' => $variant['opt3_value'],
                                    'old_price' => $variant['old_price'] ?? 0,
                                    'price' => $variant['price'],
                                    'barcode' => $variant['barcode'],
                                ]);
                            }
        
                        }
                    }
                }
            }
            \DB::commit();
            return response()->json(['status' => true, 'data'=> 'Imported Successfully']);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }
}
