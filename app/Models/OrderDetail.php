<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'free_delivery',
        'original_store_id',
        'store_id',
        'product_id',
        'original_product_id',
        'admin_id',
        'product_variant_id',
        'product_name',
        'product_variant_details',
        'product_unit_price',
        'additional_delivery_charge',
        'discount_amount',
        'product_quantity',
        'returned_quantity',
        'final_quantity',
        'sub_total',
        'total',
        'returned_amount',
        'final_amount',
        'merchant_commission',
        'product_cost',
        'order_detail_id',
        'rejected_at',
        'status'
    ];

    /**
     * Get the store that owns the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'original_store_id');
    }
}
