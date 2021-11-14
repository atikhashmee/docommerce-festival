<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Crud;
    protected $model = '\App\Models\User';

    protected $pagination = 25;
    protected $view_index = 'admin.users.index';
    protected $view_create = 'admin.users.create';
    protected $view_show = 'admin.users.show';
    protected $view_edit = 'admin.users.edit';
    protected $data = [];

    public function store(Request $request)
    {
        if (property_exists($this->model, 'rules')) {
            $validator = Validator::make($request->all(), $this->model::$rules);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['status' => false, 'data'=> $validator->errors()]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = now();
            $modelCreated = $this->model::create($data);
            if ($modelCreated) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'data'=> $modelCreated]);
                }
                return redirect()->back()->withSuccess('Data has been created');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'data'=> $e->getMessage()]);
            }
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function indexQuery(Request $request, $query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function update(Request $request, $id)
    {
        if (property_exists($this->model, 'rules')) {
            $validator = Validator::make($request->all(), $this->model::$rules);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['status' => false, 'data'=> $validator->errors()]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        try {
            $data = $request->except('_method', '_token');
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $modelCreated = $this->model::where('id', $id)->update($data);
            if ($modelCreated) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'data'=> $modelCreated]);
                }
                return redirect()->back()->withSuccess('Data has been Updated');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'data'=> $e->getMessage()]);
            }
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
