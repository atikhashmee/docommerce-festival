<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Festival extends Model
{
    use HasFactory;

    protected $table = 'festivals';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'start_at',
        'end_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public static $rules = [
        'name'     => 'required',
        'start_at' => 'required',
        'end_at'   => 'required',
    ];

    /**
     * Get all of the stores for the Festival
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_festivals', 'festival_id', 'store_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_festivals', 'festival_id', 'category_id');
    }
}
