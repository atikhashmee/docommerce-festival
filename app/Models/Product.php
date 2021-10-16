<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'store_id',
        'original_product_id',
        'original_store_id',
        'festival_id',
        'category_id',
        'name',
        'section_type',
        'original_product_url',
        'discount_type',
        'discount_amount',
        'slug',
        'short_description',
        'admin_id',
        'price',
        'old_price',
        'original_product_img',
        'is_feature',
        'is_new_arrival',
        'page_title',
        'meta_keyword',
        'meta_description',
        'visit_count',
    ];

    
}
