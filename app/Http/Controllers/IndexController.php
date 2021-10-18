<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\OrderAddress;
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
                'total_shippings_charge' => 0,
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
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'original_store_id' => $cart['original_store_id'],
                            'store_id' => $cart['store_id'],
                            'free_delivery' => 0,
                            'product_id' => $cart['id'],
                            'original_product_id' => $cart['original_product_id'],
                            'admin_id' => $cart['admin_id'],
                            'product_variant_id' => null,
                            'product_name' => $cart['name'],
                            'product_variant_details' => json_encode([]),
                            'product_unit_price' => $cart['price'],
                            'additional_delivery_charge' => 0,
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
        $data['orders'] = Order::with('orderDetails')->where('user_id', auth()->user()->id)->paginate(10);
        return view('orders', $data);
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
}
