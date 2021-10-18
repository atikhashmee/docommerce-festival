<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    
    protected $table = 'order_addresses';

    protected $fillable = [
        'name',
        'email',
        'address_type',
        'address_line_1',
        'address_line_2',
        'district_id',
        'zip_code',
        'phone',
        'state',
        'order_id',
        'state_id',
        'country_id',
    ];

}
