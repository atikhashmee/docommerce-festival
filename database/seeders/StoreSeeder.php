<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $response = Http::get('http://localhost:8000/api/festival/get-stores');
        if ($response->ok()) {
            $items = $response->collect();
            if (count($items['data']) > 0) {
                foreach ($items['data'] as $item) {
                    Store::updateOrCreate([
                        'original_store_id' => $item['original_store_id']
                    ], $item);
                }
            }
        }
    }
}
