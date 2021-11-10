<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'weight',
        'quantity',
        'original_product_img',
        'is_feature',
        'is_new_arrival',
        'page_title',
        'meta_keyword',
        'meta_description',
        'visit_count',
    ];

    public function variants()
    {
        return $this->hasMany('App\Models\ProductVariant');
    }

    /**
     * Get the store that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'original_store_id', 'original_store_id');
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    
}
