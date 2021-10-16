<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = "product_variants";

    protected $fillable = [
        'product_id',
        'festival_id',
        'store_id',
        'name',
        'opt1_name',
        'opt2_name',
        'opt3_name',
        'opt1_value',
        'opt2_value',
        'opt3_value',
        'old_price',
        'price',
        'barcode'
    ];
}
