<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;

class FestivalController extends Controller
{

    use Crud;
    protected $model = '\App\Models\Festival';
    protected $pagination = 10;
    protected $view_index = 'admin.festivals.index';
    protected $view_create = 'admin.festivals.create';
    protected $view_show = 'admin.festivals.show';
    protected $view_edit = 'admin.festivals.edit';
    protected $data = [];

}
