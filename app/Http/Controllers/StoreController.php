<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Crud;



class StoreController extends Controller
{
    use Crud;
    protected $model = '\App\Models\Store';

    protected $view_index = 'stores.index';
    protected $view_create = 'stores.create';
    protected $view_show = 'stores.show';
    protected $view_edit = 'stores.edit';
    protected $data = [];
   
}
