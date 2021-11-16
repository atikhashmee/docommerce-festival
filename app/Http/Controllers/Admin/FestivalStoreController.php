<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StoreFestival;
use App\Http\Controllers\Controller;

class FestivalStoreController extends Controller
{
    public function index(Request $request)
    {
        $sql = StoreFestival::with(['festival', 'store'])->orderBy('sort', 'ASC');
        //$records = $sql->paginate(50);
        $records = $sql->get();

        return view('admin.festival-store', compact('records'));
    }

    public function store(Request $request)
    {
        $data = StoreFestival::get();
        foreach ($data as $val) {
            $id = $val->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $val->update(['sort' => $order['position']]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Update successfully',
        ], 200);
    }   
}
