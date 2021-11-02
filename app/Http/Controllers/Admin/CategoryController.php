<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use Crud;
    protected $model = '\App\Models\Category';
    protected $pagination = 10;
    protected $view_index = 'admin.categories.index';
    protected $view_create = 'admin.categories.create';
    protected $view_show = 'admin.categories.show';
    protected $view_edit = 'admin.categories.edit';
    protected $data = [];

    public function indexQuery(Request $request, $query) {
        return $query->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
        ->where('category_festivals.festival_id', auth()->guard('admin')->user()->festival_id);
    }
}
