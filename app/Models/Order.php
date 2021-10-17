<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'store_id',
        'user_id',
        'discount_code',
        'sub_total',
        'discount_amount',
        'total_shippings_charge',
        'total_amount',
        'total_product_cost',
        'total_returned_amount',
        'total_final_amount',
        'status',
        'total_merchant_commission',
        'notes',
        'refund_status',
        'feedback_text',
        'feedback_number',
        'feedback_at'
    ];
}
