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
        $festival = $request->festival;
        $data['stores'] = Store::select('stores.*')
        ->join('store_festivals', 'store_festivals.store_id', '=', 'stores.id')
        ->where('store_festivals.festival_id', auth()->guard('admin')->user()->festival_id)
        ->get();
        $data['categories'] = Category::join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get(); 
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
        $data['products'] = $productSql->paginate(100);
        return view('admin.products.index', $data);
    }

    public function import(Request $request) {
        $data  = [];
        $festival = $request->festival;
        $data['festivals'] = Festival::get(); 
        $data['categories'] = Category::join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get(); 
        $data['stores'] = Store::select('stores.*')
        ->join('store_festivals', 'store_festivals.store_id', '=', 'stores.id')
        ->where('store_festivals.festival_id', auth()->guard('admin')->user()->festival_id)
        ->get();
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
                        $item['weight'] = 0.0;
                        $item['quantity'] = 0;
                        $item['fixed'] = 0;
                        $item['new_price'] = 0;
                        $item['category_id'] = "";
                        if (count($item['variants']) > 0) {
                            foreach ($item['variants'] as &$variant) {
                                $variant['weight'] = 0.0;
                                $variant['quantity'] = 0;
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
        $data = $request->all();
        $data['festival_id'] = auth()->guard('admin')->user()->festival_id;
        $validator = Validator::make($data, [
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
                        $discount_type = $item['percentage'] == 0 ? 'fixed' : 'percentage';
                        $old_price = $item['price'];
                        $price =  $item['price'];
                        if ($discount_type == 'fixed') {
                            $price -= $item['fixed'];
                        } else {
                            $price -= ($item['percentage'] / 100) * $item['price'] ;
                        }
                        $product = Product::updateOrCreate([
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'festival_id' => $data['festival_id']
                        ], [
                            'category_id' => $item['category_id'],
                            'store_id' => $data['store_id'],
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'name' => $item['name'],
                            'section_type' => 'hot_deals',
                            'original_product_url' => $item['original_product_url'],
                            'discount_type' => $discount_type,
                            'discount_amount' => $item['percentage'] == 0 ?  $item['fixed'] : $item['percentage'],
                            'slug' => $item['slug'],
                            'short_description' => $item['short_description'],
                            'admin_id' => $item['admin_id'],
                            'quantity' => $item['quantity'],
                            'weight' => $item['weight'],
                            'price' => $price,
                            'old_price' => $old_price ?? 0,
                            'original_product_img' => $item['original_product_img'],
                            'is_feature' => $item['is_feature'],
                            'is_new_arrival' => $item['is_new_arrival'],
                            'page_title' => $item['page_title'],
                            'meta_keyword'=> $item['meta_keyword'],
                            'meta_description' => $item['meta_description'],
                            'visit_count' => $item['visit_count'],
                        ]);
                        $dataArr = [];
                        if (count($item['variants']) > 0) {
                            foreach ($item['variants'] as $variant) {
                                ProductVariant::where([
                                    'store_id' => $item['original_store_id'], 
                                    'original_product_id' => $item['original_product_id'],
                                    'festival_id' => $data['festival_id']
                                ])->delete();
                                $var_discount_type = $variant['percentage'] == 0 ? 'fixed' : 'percentage';
                                $var_old_price = $variant['price'];
                                $var_price =  $variant['price'];
                                if ($var_discount_type == 'fixed') {
                                    $var_price -= $variant['fixed'];
                                } else {
                                    $var_price -= ($variant['percentage'] / 100) * $variant['price'] ;
                                }

                                $dataArr[] = [
                                    'product_id' => $product->id,
                                    'original_product_id' => $product->original_product_id,
                                    'festival_id' => $data['festival_id'],
                                    'store_id' => $data['store_id'],
                                    'name' => $variant['name'],
                                    'discount_type' => $var_discount_type,
                                    'discount_amount' => $variant['percentage'] == 0 ?  $variant['fixed'] : $variant['percentage'],
                                    'opt1_name' => $variant['opt1_name'],
                                    'opt2_name' => $variant['opt2_name'],
                                    'opt3_name' => $variant['opt3_name'],
                                    'opt1_value' => $variant['opt1_value'],
                                    'opt2_value' => $variant['opt2_value'],
                                    'opt3_value' => $variant['opt3_value'],
                                    'old_price' => $var_old_price ?? 0,
                                    'weight' => $variant['weight'],
                                    'price' =>  $var_price,
                                    'quantity' => $variant['quantity'],
                                    'barcode' => $variant['barcode'],
                                ];
                            }
                            ProductVariant::insert($dataArr);
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

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item  = Product::find($id);
        if ($item) {
            if (count($item->variants) > 0) {
                $item->variants()->delete();
            }
            $item->delete();
            if (request()->ajax()) {
                return response(['status'=> true, 'data' => 'Data is deleted']);
            }
            return redirect()->back()->withSuccess('Data is deleted');
        } else {
            if (request()->ajax()) {
                return response(['status'=> false, 'data' => 'Data not found']);
            } else {
                return redirect()->back()->withError('Data not found');
            } 
        }
    }

    public function bulkDelete(Request $request) {
        $ids = json_decode($request->product_ids, true);
        $ids = collect($ids)->filter(function($item) {return $item != null;})->toArray();
        Product::whereIn('id', $ids)->delete();
        return response(['status'=> true, 'data' => 'Data is deleted']);
    }
}
