<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreFestival extends Model
{
    use HasFactory;

    protected $table = 'store_festivals';

    protected $fillable = [
        'festival_id',
        'store_id',
        'img',
    ];
}
