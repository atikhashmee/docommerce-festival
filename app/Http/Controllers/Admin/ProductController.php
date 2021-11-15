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

    public $sections = ["hot_deals", "new_arrival"];
    public function index(Request $request)
    {
        $data  = [];
        $festival = $request->festival;
        $data['stores'] = Store::select('stores.*', \DB::raw("IFNULL(P.total_products, 0) as total_products"))
        ->join('store_festivals', 'store_festivals.store_id', '=', 'stores.id')
        ->leftJoin(\DB::raw("(SELECT COUNT(id) as total_products, original_store_id FROM products GROUP BY original_store_id) as P"), "P.original_store_id", "=", "stores.original_store_id")
        ->where('store_festivals.festival_id', auth()->guard('admin')->user()->festival_id)
        ->get();
        $data['categories'] = Category::select("categories.*", \DB::raw("IFNULL(C.total_products, 0) as total_products"))
        ->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw("(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) as C"), "C.category_id", "=", "categories.id")
        ->where('category_festivals.festival_id', $festival->id)->get(); 
        $productSql = Product::select('*');
        $productSql->where(function($q) use($request) {
            if ($request->category_id) {
                $q->where('category_id', $request->category_id);
            }

            if ($request->store_id) {
                $q->where('store_id', $request->store_id);
            }
            if ($request->type) {
                if ($request->type == 'hot_deal') {
                    $q->where('section_type', '{"hot_deal":"1", "exclusive":"0"}');
                } elseif ($request->type == 'exclusive') {
                    $q->where('section_type', '{"hot_deal":"0", "exclusive":"1"}');
                } elseif ($request->type == 'hot_exclusive') {
                    $q->where('section_type', '{"hot_deal":"1", "exclusive":"1"}');
                } elseif ($request->type == 'no_hot_exclusive') {
                    $q->where(function($r) {
                        $r->whereNull('section_type');
                        $r->orWhere('section_type', '{"hot_deal":"0", "exclusive":"0"}');
                    });
                }
            }

            if ($request->search) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            }
        });
        $data['products'] = $productSql->paginate(100);
        $data['sections'] = $this->sections;
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
        $data['sections'] = $this->sections;
        return view('admin.products.import', $data);
    }
    public function storeProduct($store_id) {
        $productCollect = [];
        if ($store_id) {
            $response = Http::withoutVerifying()->get(env("REMOTE_BASE_URL").'/api/festival/get-products/'.$store_id);
            if ($response->ok()) {
                $items = $response;
                if (count($items['data']) > 0) {
                    foreach ($items['data'] as $item) {
                        $item['section_type'] = "";
                        $item['percentage'] = 0;
                        $item['weight'] = 0.0;
                        $item['quantity'] = 0;
                        $item['fixed'] = 0;
                        $item['new_price'] = 0;
                        $item['checked'] = false;
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

        //temporary
        $store = Store::where('original_store_id', $data['store_id'])->first();

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
                            $price -= ($item['percentage'] / 100) * $item['price'];
                        }
                        $product = Product::updateOrCreate([
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'festival_id' => $data['festival_id']
                        ], [
                            'category_id' => $item['category_id'],
                            'store_id' => $store->id,
                            'original_store_id' => $item['original_store_id'],
                            'original_product_sequence_id' => $item['sequence_id'],
                            'original_product_id' => $item['original_product_id'],
                            'name' => $item['name'],
                            'section_type' => $item['section_type'] !=="" ? $item['section_type']: "hot_deals",
                            'original_product_url' => $item['original_product_url'],
                            'discount_type' => $discount_type,
                            'discount_amount' => $item['percentage'] == 0 ?  $item['fixed'] : $item['percentage'],
                            'slug' => $item['slug'],
                            'short_description' => $item['short_description'],
                            'description' => $item['description'],
                            'admin_id' => $item['admin_id'],
                            'quantity' => $item['quantity'],
                            'weight' => $item['weight'],
                            'price' => $price,
                            'old_price' => $old_price ?? 0,
                            'original_product_img' => $item['original_product_img'],
                            'other_images' => $item['images'],
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
                                    'store_id' => $store->id,
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

    public function bulkChange(Request $request) 
    {
        $ids = json_decode($request->product_ids, true);
        $ids = collect($ids)->filter(function($item) {return $item != null;})->toArray();

        if ($request->type == 'hot_deal') {
            Product::whereIn('id', $ids)->update(['section_type' => '{"hot_deal":"1", "exclusive":"0"}']);
        } elseif ($request->type == 'exclusive') {
            Product::whereIn('id', $ids)->update(['section_type' => '{"hot_deal":"0", "exclusive":"1"}']);
        } elseif ($request->type == 'hot_exclusive') {
            Product::whereIn('id', $ids)->update(['section_type' => '{"hot_deal":"1", "exclusive":"1"}']);
        } elseif ($request->type == 'remove_hot_exclusive') {
            Product::whereIn('id', $ids)->update(['section_type' => '{"hot_deal":"0", "exclusive":"0"}']);
        }
        return response(['status'=> true, 'data' => 'Data is updated']);
    }

    public function bulkDelete(Request $request) {
        $ids = json_decode($request->product_ids, true);
        $ids = collect($ids)->filter(function($item) {return $item != null;})->toArray();
        Product::whereIn('id', $ids)->delete();
        return response(['status'=> true, 'data' => 'Data is deleted']);
    }

    public function edit(Request $request, $id) {
        $festival = $request->festival;
        $data['product'] = Product::with('variants')->where('id', $id)->first();
        if (!$data['product']) {
            return redirect()->back()->withError('Data not found');
        }
        $data['product']->percentage = $data['product']->discount_type == 'percentage' ? $data['product']->discount_amount : 0;      
        $data['product']->fixed = $data['product']->discount_type == 'fixed' ? $data['product']->discount_amount : 0; 
        $data['product']->new_price = 0;

        if ($data['product']->discount_type == 'percentage') {
            $data['product']->new_price =  $data['product']->old_price - ($data['product']->old_price * ($data['product']->discount_amount / 100));
        } else {
            $data['product']->new_price =  $data['product']->old_price - $data['product']->discount_amount;
        }

        if (count($data['product']->variants) > 0) {
           foreach ($data['product']->variants as  &$ver) {
                $ver->percentage =  $ver->discount_type == 'percentage' ?  $ver->discount_amount : 0;      
                $ver->fixed      =  $ver->discount_type == 'fixed' ?  $ver->discount_amount : 0; 
                $ver->new_price = 0;
                if ($ver->discount_type == 'percentage') {
                    $ver->new_price =  $ver->old_price - ($ver->old_price * ($ver->discount_amount / 100));
                } else {
                    $ver->new_price =  $ver->old_price - $ver->discount_amount;
                }
           }
        }

        $data['sections'] = $this->sections;
        $data['categories'] = Category::join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get();
        return view('admin.products.edit', $data);
    }

    public function update(Request $request, $id) {
        try {
            \DB::beginTransaction();
            $item = json_decode( $request->product, true);
            $discount_type = $item['percentage'] == 0 ? 'fixed' : 'percentage';
            $old_price = $item['price'];
            $price =  $item['price'];
            if ($discount_type == 'fixed') {
                $price -= $item['fixed'];
            } else {
                $price -= ($item['percentage'] / 100) * $item['price'] ;
            }
            $product = Product::where('id', $id)->update([
                'section_type' => $item['section_type'] ?? "hot_deals",
                'discount_type' => $discount_type,
                'discount_amount' => $item['percentage'] == 0 ?  $item['fixed'] : $item['percentage'],
                'short_description' => $item['short_description'],
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'weight' => $item['weight'],
                'price' => $price,
                'old_price' => $old_price ?? 0
            ]);
            if ($product) {
                $dataArr = [];
                if (count($item['variants']) > 0) {
                    foreach ($item['variants'] as $variant) {
                        ProductVariant::where([
                            'store_id' => $item['original_store_id'], 
                            'original_product_id' => $item['original_product_id'],
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
                            'product_id' => $id,
                            'original_product_id' => $item['original_product_id'],
                            'festival_id' => $item['festival_id'],
                            'store_id' => $item['store_id'],
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
                \DB::commit();
                return response()->json(['status' => true, 'data'=> "Updated successfully"]);
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }

    public function productUpdateSync(Request $request) {
        $products_ids = json_decode($request->selected_products, true);
        $products_ids = array_filter($products_ids, function($q){return $q!=null;});
        $requestData = $request->all();
        $requestData['selected_products'] = $products_ids;
        $validator = Validator::make($requestData, [
            'selected_products' => 'required|array',
            'column'  => 'required|array',
            'column.*'=> 'required|in:name,slug,short_description,description,images,price',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $db_products = Product::whereIn('id', $products_ids)->get();
            $total_updated_products = 0;
            if (count($db_products) > 0) {
                $original_product_ids = $db_products->map(function($qq){return $qq->original_product_id;})->toArray();
                $response = Http::withoutVerifying()->post(env("REMOTE_BASE_URL").'/api/festival/get-products-by-id', [
                    'product_ids' => json_encode($original_product_ids),
                    
                ]);
    
                if ($response->ok()) {
                    if ($response->successful()) {
                        $data = $response->json();
                        if (count($data['data']) > 0) {
                            foreach ($data['data'] as $key => $product) {
                                if ( count($db_products) > 0) {
                                    foreach ($db_products as $db_product) {
                                        if ($product['original_product_id'] == $db_product->original_product_id && $product['original_store_id'] == $db_product->original_store_id) {
                                         
                                            if (in_array('slug', $request->column)) {
                                                $db_product->slug = $product['slug'];
                                            }
    
                                            if (in_array('name', $request->column)) {
                                                $db_product->name = $product['name'];
                                            }
                                            
                                            if (in_array('short_description', $request->column)) {
                                                $db_product->short_description = $product['short_description'];
                                            }

                                            if (in_array('description', $request->column)) {
                                                $db_product->description = $product['description'];
                                            }
    
                                            if (in_array('images', $request->column)) {
                                                $db_product->other_images = $product['images'];
                                                $db_product->original_product_img = $product['original_product_img'];
                                            }
    
                                            if (in_array('price', $request->column)) {
                                                if (count($db_product->variants) > 0) {
                                                    foreach ($db_product->variants as $key => $variant) {
                                                        if (count($product['variants']) > 0) {
                                                            foreach ($product['variants'] as $pvar) {
                                                                if ($product['original_product_id'] == $db_product->original_product_id && $db_product->store_id == $variant->store_id) {
                                                                    $variant->old_price = $pvar['price'];
                                                                    if ($variant->discount_type == 'fixed') {
                                                                        $variant->price = $variant->old_price - $variant->discount_amount;
                                                                    } else if ($variant->discount_type == 'percentage') {
                                                                        $variant->price = $variant->old_price - (($variant->discount_amount / 100) * $variant->old_price);
                                                                    }
                                                                }
                                                            }
                                                            $variant->save();
                                                        }
                                                    }
                                                } else {
                                                    $db_product->old_price = $product['price'];
                                                    if ($db_product->discount_type == 'fixed') {
                                                        $db_product->price = $db_product->old_price - $db_product->discount_amount;
                                                    } else if ($db_product->discount_type == 'percentage') {
                                                        $db_product->price = $db_product->old_price - (($db_product->discount_amount / 100) * $db_product->old_price);
                                                    }
                                                }
                                            }
                                            $db_product->save();
                                            $total_updated_products++;
                                        }
                                    }
                                }
                            }
                        }
                    } 
                }
            }
            return redirect()->back()->withSuccess($total_updated_products." Products have been updated");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
