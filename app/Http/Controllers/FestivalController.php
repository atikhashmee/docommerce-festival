<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FestivalController extends Controller
{
    protected $model = '\App\Models\Festival';

    protected $view_index = 'festivals.index';
    protected $view_create = 'festivals.create';
    protected $view_show = 'festivals.show';
    protected $view_edit = 'festivals.edit';
    protected $data = [];

}
