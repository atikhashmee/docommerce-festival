<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::get()->map(function($store){
            $response = Http::get('http://localhost:8000/api/festival/get-products/'.$store->original_store_id);
            if ($response->ok()) {
                $items = $response->collect();
                if (count($items['data']) > 0) {
                    foreach ($items['data'] as $item) {
                        $product = Product::updateOrCreate([
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'festival_id' => 1
                        ], [
                            'category_id' => 1,
                            'store_id' => $store->id,
                            'original_store_id' => $item['original_store_id'],
                            'original_product_id' => $item['original_product_id'],
                            'name' => $item['name'],
                            'section_type' => 'hot_deals',
                            'original_product_url' => $item['original_product_url'],
                            'discount_type' => 'percentage',
                            'discount_amount' => 10,
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
                                    'festival_id' => 1
                                ], [
                                    'product_id' => $product->id,
                                    'festival_id'  => 1,
                                    'store_id' => $store->id,
                                    'name' => $variant['name'],
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
            return $store;
        });
        
    }
}
