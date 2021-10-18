<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
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

    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function orderDetails () {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
