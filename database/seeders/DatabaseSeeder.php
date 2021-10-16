<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  \App\Models\User::factory(10)->create();

         \App\Models\Festival::factory(10)->create();
         \App\Models\Category::factory(10)->create();
         $this->call([StoreSeeder::class, ProductSeeder::class]);

        // tried to fill relational table filled up. but don't work
        // \App\Models\Festival::factory()->has(\App\Models\Store::factory()->count(10))->count(10)->create();
        // store festival table
        \App\Models\Store::get()->map(function($item) {
            \App\Models\StoreFestival::create([
                'festival_id' => 1,
                'store_id' => $item->id,
            ]);
            return $item;
        });

        // festival cateogry 
        \App\Models\Category::get()->map(function($item) {
            \App\Models\CategoryFestival::create([
                'festival_id' => 1,
                'category_id' => $item->id,
            ]);
            return $item;
        });

    }
}
