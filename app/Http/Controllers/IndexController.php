<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\BulkOrder;
use App\Models\OrderDetail;
use App\Models\Perticipant;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index() {
        $festival = request()->festival; 
        $data = [];
        $data['stores']  = Store::join('store_festivals', 'store_festivals.store_id', '=', 'stores.id')
        ->where('store_festivals.festival_id', $festival->id)->get();
        $hot_deals = Product::withCount('variants')->take(10)->limit(10)->paginate(10);
        $exclusives = Product::withCount('variants')->take(1)->limit(10)->paginate(10);
        $this->processedProductData($hot_deals->getCollection());
        $this->processedProductData($exclusives->getCollection());
        $data['hot_deals'] = $hot_deals;
        $data['exclusives'] = $exclusives;
        return view('index', $data);
    }

    public function detail($slug)
    {
        $data = [];
        $product  = Product::with('variants', 'category', 'store')->where('slug', $slug)->first();
        $data['product'] =  $this->processedProductDetails($product);
        //dd($data['product']);
        return view('product_detail', $data);
    }

    public function quickView($id)
    {
        $data = [];
        $product  = Product::with('variants', 'category', 'store')->where('id', $id)->first();
        $data['product'] =  $this->processedProductDetails($product);
        return view('web-components._detail', $data);
    }

    public function dashboard(Request $request)
    {
        $data = [];
        $data['total_order'] = Order::where('user_id', auth()->user()->id)->count();
        $data['total_order_amount'] = Order::where('user_id', auth()->user()->id)->sum('total_final_amount');

        $data['last_five_orders_product'] = OrderDetail::select('products.*')
        ->join('products', function($q) {
            $q->on('order_details.product_id', '=', 'products.id');
        })
        ->join('orders', function($q) {
            $q->on('order_details.order_id', '=', 'orders.id');
            $q->where('orders.user_id', '=', auth()->user()->id);
        })
        ->groupBy('order_details.product_id')
        ->orderBy(DB::raw('MAX(order_details.id)'), 'DESC')
        ->limit(5)
        ->get();

        return view('home', $data);
    }

    public function storeData(Request $request, $store_id)
    {
        $festival = $request->festival; 
        $data = [];
        $data['store'] = Store::where('original_store_id', $store_id)->first();
        $exclusives = Product::withCount('variants')->where('original_store_id', $store_id)
        ->where('festival_id', $festival->id)
        ->where(function($q)  {
            if (isset(request()->price_range) && !empty(request()->price_range)) {
                $q->whereBetween('products.price', explode(',', request()->price_range));
            }
            $q->where("name", "LIKE", "%".request()->search."%");
            $q->orWhere("slug", "LIKE", "%".request()->search."%");
        });
        if ($request->sort_letter) {
            if ($request->sort_letter == "a-z") {
                $exclusives->orderBy('name', 'ASC');
            } else {
                $exclusives->orderBy('name', 'DESC');
            }
        } 

        if ($request->sort_price) {
            if ($request->sort_price == "low-high") {
                $exclusives->orderBy('price', 'ASC');
            } else {
                $exclusives->orderBy('price', 'DESC');
            }
        } 
        
        $data['max_price'] = $exclusives->get()->max('price');
        //$exclusives->take(1)->limit(10);
        $exclusivesData = $exclusives->paginate(12);     
        $this->processedProductData($exclusivesData->getCollection());
        $data['exclusives'] = $exclusivesData;     
        $data['categories']  = Category::select('categories.*', 'TP.total_products')->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) TP'), 'TP.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get();
        return view('products', $data);
    }

    public function categoryData(Request $request, $category_id) {
        $festival = $request->festival; 
        $data = [];
        $data['category'] = Category::where('id', $category_id)->first();
        $exclusives = Product::withCount('variants')
        ->where('category_id', $category_id)
        ->where('festival_id', $festival->id)
        ->where(function($q)  {
            if (isset(request()->price_range) && !empty(request()->price_range)) {
                $q->whereBetween('products.price', explode(',', request()->price_range));
            }
            $q->where("name", "LIKE", "%".request()->search."%");
            $q->orWhere("slug", "LIKE", "%".request()->search."%");
        });

        if ($request->sort_letter) {
            if ($request->sort_letter == "a-z") {
                $exclusives->orderBy('name', 'ASC');
            } else {
                $exclusives->orderBy('name', 'DESC');
            }
        } 

        if ($request->sort_price) {
            if ($request->sort_price == "low-high") {
                $exclusives->orderBy('price', 'ASC');
            } else {
                $exclusives->orderBy('price', 'DESC');
            }
        } 

        $data['max_price'] = $exclusives->get()->max('price');
        //$exclusives->take(1)->limit(10);
        $exclusivesData = $exclusives->paginate(12);     
        $this->processedProductData($exclusivesData->getCollection());   
        $data['exclusives'] = $exclusivesData;  
        $data['categories']  = Category::select('categories.*', 'TP.total_products')->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) TP'), 'TP.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get();
        return view('products', $data);
    }

    public function products(Request $request) {
        $festival = $request->festival; 
        $data = [];
        $exclusives = Product::withCount('variants')
        ->where('festival_id', $festival->id)
        ->where(function($q) use($request) {
            if (isset(request()->price_range) && !empty(request()->price_range)) {
                $q->whereBetween('products.price', explode(',', request()->price_range));
            }
            $q->where("name", "LIKE", "%".$request->search."%");
            $q->orWhere("slug", "LIKE", "%".$request->search."%");
        });
        if ($request->sort_letter) {
            if ($request->sort_letter == "a-z") {
                $exclusives->orderBy('name', 'ASC');
            } else {
                $exclusives->orderBy('name', 'DESC');
            }
        } 

        if ($request->sort_price) {
            if ($request->sort_price == "low-high") {
                $exclusives->orderBy('price', 'ASC');
            } else {
                $exclusives->orderBy('price', 'DESC');
            }
        } 
        $data['max_price'] = $exclusives->get()->max('price');
        //$exclusives->take(1)->limit(10);
        $exclusivesData = $exclusives->paginate(12);     
        $this->processedProductData($exclusivesData->getCollection());   
        $data['exclusives'] = $exclusivesData;  
        $data['categories']  = Category::select('categories.*', 'TP.total_products')->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->leftJoin(\DB::raw('(SELECT COUNT(id) as total_products, category_id FROM products GROUP BY category_id) TP'), 'TP.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', $festival->id)->get();
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
            $data = $request->all();
            $sub_total = 0;
            $total = 0;
            if (count($cartItems) > 0) {
                foreach ($cartItems as $cart) {
                    $sub_total += $cart['price'] * $cart['quantity'];
                    $total += $cart['price'] * $cart['quantity'];
                }
            }
            $discount = 0;
            $note = '';
            $order = Order::create([
                'order_number' => now(),
                'user_id'  => auth()->user()->id,
                'sub_total' => $sub_total,
                'discount_amount' => $discount,
                'total_shippings_charge' => $data['cart_shipping_page'] ?? 0,
                'total_amount' => $total,
                'total_product_cost' => 0,
                'total_returned_amount' => 0,
                'total_final_amount' => $total,
                'notes' => $note,
            ]);
            if ($order) {
                OrderAddress::create([
                    'name'  => $data['name'],
                    'email'  => $data['email'],
                    'address_type'  => null,
                    'address_line_1'  => $data['address_line_1'],
                    'address_line_2' => $data['address_line_2'],
                    'district_id'  => $data['district_id'],
                    'zip_code'  => $data['zip_code'],
                    'phone'  => $data['phone'],
                    'order_id'  => $order->id,
                    'state_id'  => $data['state_id'],
                    'country_id'  => 19,
                ]);
                if (count($cartItems) > 0) {
                    foreach ($cartItems as $cart) {
                        $variant_id = null;
                        $variant_detail = [];
                        $additional_charge = 0;
                        if ($cart['selected_variant'] != null) {
                            $splitted_product_id = explode('_',  $cart['id']);
                            $cart['id'] = $splitted_product_id[0];
                            $variant_id = $splitted_product_id[1];
                            $variant_detail =  $cart['selected_variant'];
                        }

                        // weight calculate
                        if ($cart['weight'] > 0) {
                            $additional_charge = $cart['quantity'] * ceil(floatval($cart['weight']));
                        }

                        //check stock
                        // $product = Product::where('id', $cart['id'])->first();
                        // if (intval($cart['quantity']) > $product->quantity ) {
                        //     throw new \Exception($product->name." Stock does not meet given Quantity", 1);
                        // }

                        $detailed = OrderDetail::create([
                            'order_id' => $order->id,
                            'original_store_id' => $cart['original_store_id'],
                            'store_id' => $cart['store_id'],
                            'free_delivery' => 0,
                            'product_id' => $cart['id'],
                            'original_product_id' => $cart['original_product_id'],
                            'admin_id' => $cart['admin_id'],
                            'product_variant_id' => $variant_id,
                            'product_name' => $cart['name'],
                            'product_variant_details' => $variant_detail,
                            'product_unit_price' => $cart['price'],
                            'shipping_charge' => 60,
                            'additional_delivery_charge' => $additional_charge,
                            'discount_amount' => 0,
                            'product_quantity' =>  $cart['quantity'],
                            'returned_quantity' => 0,
                            'final_quantity'=>  $cart['quantity'],
                            'sub_total' =>  $cart['quantity'] * $cart['price'],
                            'total' => ($cart['quantity'] * $cart['price']) - 0,
                            'returned_amount' => 0,
                            'final_amount' => ($cart['quantity'] * $cart['price']) - 0,
                            'merchant_commission' => 0,
                            'product_cost' => 0,
                        ]);
                        // if ($detailed) {
                        //     $product->quantity -= $cart['quantity'];
                        //     $product->save();
                        // }
                    }
                }
            }
            \DB::commit();
            return response()->json(['status' => true, 'success' => 'Order has been placed', 'data' => $order->id]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }

    }

    public function orderCompleted($id) {
        return view('order_placed');
    }

    public function orders() {
        $data = [];
        $data['orders'] = Order::withCount('orderDetails')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('orders', $data);
    }

    public function orderDetail($order_id)
    {
        $data['order'] = Order::with(['orderDetails', 'address' => function($q){
            $q->select('order_addresses.*', 'global_states.name as state_name', 'global_districts.name as district_name');
            $q->leftJoin('global_states', 'global_states.id', '=', 'order_addresses.state_id');
            $q->leftJoin('global_districts', 'global_districts.id', '=', 'order_addresses.district_id');
        }])
        ->where('id', $order_id)
        ->where('user_id', auth()->user()->id)
        ->first();
        return view('order_detail', $data);
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $updated = User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
        if ($updated) {
            return redirect()->back()->withSuccess('Updated');
        } else {
            return redirect()->back()->withError('Error');
        }
    }

    public function processedProductDetails($item)
    {
        $item->original_product_img = "https://zipgrip.delivery".strstr($item->original_product_img, '/storage');

        $item->variants = $item->variants != null ? json_decode($item->variants) : [];
        $item->stock_quantity = $item->quantity;
        $item->quantity = 1;
        $show_variants = [];
        $smallest_variant = null;
        $min_variant_price = 0;
        if (!empty($item->variants)) {
            foreach ($item->variants as $variant) {
                if ($variant->opt1_name != null && $variant->opt1_value != null) {
                    $show_variants[$variant->opt1_name][$variant->opt1_value] = (object) [
                        'id' => $variant->id,
                        'value' => $variant->opt1_value,
                        'price' => $variant->price,
                        'old_price' => $variant->old_price,
                    ];
                }

                if ($variant->opt2_name != null && $variant->opt2_value != null) {
                    $show_variants[$variant->opt2_name][$variant->opt2_value] = (object) [
                        'id' => $variant->id,
                        'value' => $variant->opt2_value,
                        'price' => $variant->price,
                        'old_price' => $variant->old_price,
                    ];
                }

                if ($variant->opt3_name != null && $variant->opt3_value != null) {
                    $show_variants[$variant->opt3_name][$variant->opt3_value] = (object) [
                        'id' => $variant->id,
                        'value' => $variant->opt3_value,
                        'price' => $variant->price,
                        'old_price' => $variant->old_price,
                    ];
                }

                if (isset($variant->price)) {
                    if ($variant->price < $min_variant_price || $min_variant_price == 0) {
                        $min_variant_price = $variant->price;
                        $smallest_variant = $variant;
                    }
                }
            }


            if ($smallest_variant != null) {
                $item->price = $smallest_variant->price;
                $item->old_price = $smallest_variant->old_price;
            }
        }
        $item->show_variants = $show_variants;
        $item->smallest_variant = $smallest_variant;
        return $item;
    }

    public function showComingSoon() {
        return view('coming-soon');
    }

    public function storePerticipant(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'phone_number' => 'required|unique:perticipants,phone_number',
            'business_name' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Perticipant::create($request->all());
        return redirect()->back()->withSuccess('Success');
    }

    public function processedProductData(Collection $arrData)
    {
        $arrData->map(function($item) {
            $item->original_product_img = "https://zipgrip.delivery".strstr($item->original_product_img, '/storage');

            $variants = [];
            $smallest_variant = null;
            if (count($item->variants)>0) {
                $item->raw_variants = $item->variants->map(function($item) {
                    $vc = new \stdclass;
                    $vc->id  = $item->id;
                    $vc->name = $item->name;
                    $vc->opt1_value = $item->opt1_value;
                    $vc->opt2_value = $item->opt2_value;
                    $vc->opt3_value = $item->opt3_value;
                    $vc->old_price = $item->old_price;
                    $vc->discount_type = $item->discount_type;
                    $vc->discount_amount = $item->discount_amount;
                    $vc->price = $item->price;
                    return $vc;
                });

                $price = 0;
                foreach ($item->variants as $variant) {
                    if ($variant->opt1_name != null && $variant->opt1_value !=null) {
                        $opt1 = new \stdclass;
                        $opt1->value = $variant->opt1_value;
                        $opt1->id = $variant->id;
                        $opt1->price = $variant->price;
                        $opt1->old_price = $variant->old_price;
                        $variants[$variant->opt1_name][$variant->opt1_value] = $opt1;
                    }

                    if ($variant->opt2_name != null && $variant->opt2_value != null) {
                        $opt2 = new \stdclass;
                        $opt2->value = $variant->opt2_value;
                        $opt2->id = $variant->id;
                        $opt2->price = $variant->price;
                        $opt2->old_price = $variant->old_price;
                        $variants[$variant->opt2_name][$variant->opt2_value] = $opt2;
                    }
                    if ($variant->opt3_name != null && $variant->opt3_value != null) {
                        $opt3 = new \stdclass;
                        $opt3->value = $variant->opt3_value;
                        $opt3->id = $variant->id;
                        $opt3->price = $variant->price;
                        $opt3->old_price = $variant->old_price;
                        $variants[$variant->opt3_name][$variant->opt3_value] = $opt3;
                    }

                    if (isset($variant->price)) {
                        if ($variant->price < $price || $price ==0) {
                            $price = $variant->price;
                            $smv = new \stdclass;
                            $smv->opt1_value = $variant->opt1_value;
                            $smv->opt2_value = $variant->opt2_value;
                            $smv->opt3_value = $variant->opt3_value;
                            $smv->discount_type = $variant->discount_type;
                            $smv->discount_amount = $variant->discount_amount;
                            $smv->id = $variant->id;
                            $smv->price = $variant->price;
                            $smv->old_price = $variant->old_price;
                            $smallest_variant = $smv;
                        }
                    }
                }

                if ($smallest_variant!=null) {
                    $item->price = $smallest_variant->price;
                    $item->old_price = $smallest_variant->old_price;
                    $item->discount_type = $smallest_variant->discount_type;
                    $item->discount_amount = $smallest_variant->discount_amount;
                }
            }
            $item->variants = $variants;
            $item->smallest_variant = $smallest_variant;
            $item->stock_quantity = $item->quantity;
            $item->quantity = 1;
            return $item;
        });
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function bulkOrderCreate($product_id) {
        if (!isset($product_id)) {
            abort(404);
            return redirect(route('index_page'));
        }
        $product = Product::where('id', $product_id)->first();
        if (!$product) {
            return redirect(route('index_page'));
        }
        $data['product'] = $product;
        return view('bulk-order', $data);
    }

    public function submitBulkOrderInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'product_name' => 'required',
            'product_quantity' => 'required|numeric',
            'full_name' => 'required',
            'mobile_number' => 'required',
            'email' => 'email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            BulkOrder::create($request->except('_token'));
            return redirect(route('thank_you_page'));
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function bulkOrderCompleted()
    {
        return view('bulk-order-completed');
    }

    
}
