<?php

namespace App\Http\Controllers;



class StoreController extends Controller
{
    protected $model = '\App\Models\Store';

    protected $view_index = 'stores.index';
    protected $view_create = 'stores.create';
    protected $view_show = 'stores.show';
    protected $view_edit = 'stores.edit';
    protected $data = [];
   
}
