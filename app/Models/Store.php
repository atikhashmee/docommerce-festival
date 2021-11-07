<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Festival;
use App\Models\StoreFestival;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
      /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'original_store_id',
        'name',
        'store_url',
        'store_logo_url',
        'store_slogan',
        'store_domain',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'original_store_id' => 'integer',
        'name' => 'string',
        'store_url' => 'string',
        'store_logo_url' => 'string',
        'store_slogan' => 'string',
        'store_domain' => 'string',
    ];

    public static $rules = [
        'original_store_id' => 'required',
        'name' => 'required',
    ];

    public function festivals()
    {
        return $this->belongsToMany(Festival::class, 'store_festivals', 'festival_id', 'store_id');
    }

    // protected static function booted()
    // {
    //     static::created(function ($store) {
    //         StoreFestival::create(['store_id' => $store->id, 'festival_id' => auth()->guard('admin')->user()->festival_id]);
    //     });
    // }

    /**
     * Get all of the products for the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
