<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
