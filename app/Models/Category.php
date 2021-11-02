<?php

namespace App\Models;

use App\Models\Festival;
use App\Models\CategoryFestival;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    protected static function booted()
    {
        static::created(function ($category) {
            CategoryFestival::create(['category_id' => $category->id, 'festival_id' => auth()->guard('admin')->user()->festival_id]);
        });
    }

    public function festivals()
    {
        return $this->belongsToMany(Festival::class, 'category_festivals', 'festival_id', 'category_id');
    }
}
