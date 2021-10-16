<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Crud {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($this->pagination)) {
            $data['items'] = $this->model::paginate(intval($this->pagination));
        } else {
            $data['items'] = $this->model::get();
        }
        if ($request->ajax()) {
            return response(['status'=> true, 'data' => $data]);
        }
        return view($this->view_index, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view_create, $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->model::$rules);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'data'=> $validator->errors()]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $modelCreated = $this->model::create($request->all());
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item  = $this->model::find($id);
        if ($item) {
            $this->data['item'] = $item;
            if (request()->ajax()) {
                return response(['status'=> true, 'data' => $this->data]);
            }
        } else {
            if (request()->ajax()) {
                return response(['status'=> false, 'data' => 'Data not found']);
            } else {
                return redirect()->back()->withError('Data not found');
            } 
        }
        return view($this->view_show, $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item  = $this->model::find($id);
        if ($item) {
            $this->data['item'] = $item;
            if (request()->ajax()) {
                return response(['status'=> true, 'data' => $this->data]);
            }
        } else {
            if (request()->ajax()) {
                return response(['status'=> false, 'data' => 'Data not found']);
            } else {
                return redirect()->back()->withError('Data not found');
            } 
        }
        return view($this->view_edit, $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->model::$rules);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'data'=> $validator->errors()]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $modelCreated = $this->model::where('id', $id)->update($request->all());
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item  = $this->model::find($id);
        if ($item) {
            $item->delete();
            if (request()->ajax()) {
                return response(['status'=> true, 'data' => 'Data is deleted']);
            }
            return redirect()->back()->withSuccess('Data is deleted');
        } else {
            if (request()->ajax()) {
                return response(['status'=> false, 'data' => 'Data not found']);
            } else {
                return redirect()->back()->withError('Data not found');
            } 
        }
    }
}