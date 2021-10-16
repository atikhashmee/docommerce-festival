<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Crud;

class FestivalController extends Controller
{

    use Crud;
    protected $model = '\App\Models\Festival';

    protected $view_index = 'festivals.index';
    protected $view_create = 'festivals.create';
    protected $view_show = 'festivals.show';
    protected $view_edit = 'festivals.edit';
    protected $data = [];

}
