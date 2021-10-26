<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;



class StoreController extends Controller
{
    use Crud;
    protected $model = '\App\Models\Store';

    protected $view_index = 'admin.stores.index';
    protected $view_create = 'admin.stores.create';
    protected $view_show = 'admin.stores.show';
    protected $view_edit = 'admin.stores.edit';
    protected $data = [];
   
}
