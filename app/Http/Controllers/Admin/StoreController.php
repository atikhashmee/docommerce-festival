<?php

namespace App\Http\Controllers\Admin;

use App\Models\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    use Crud;
    protected $model = '\App\Models\Store';

    protected $pagination = 25;
    protected $view_index = 'admin.stores.index';
    protected $view_create = 'admin.stores.create';
    protected $view_show = 'admin.stores.show';
    protected $view_edit = 'admin.stores.edit';
    protected $data = [];

    public function syncStoreData() {
        $response = Http::get(env("REMOTE_BASE_URL").'/api/festival/get-stores');
        if ($response->ok()) {
            $items = $response->collect();
            if (count($items['data']) > 0) {
                foreach ($items['data'] as $item) {
                    $this->model::updateOrCreate([
                        'original_store_id' => $item['original_store_id']
                    ], $item);
                }
            }
        }
        return redirect()->back()->withSuccess('Data has been synced');
    }

    public function attachToFestival(Request $request) {
        $storids = json_decode($request->store_ids, true);
        $storids = collect($storids)->filter(function($item) {return $item !=null;});
        try {
            $festival = Festival::find($request->festival_id);
            if ($festival) {
                $festival->stores()->sync($storids);
            }
            return response()->json(['status' => true, 'data'=> "Data has been attached"]);
        } catch (\Exception $e) {       
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }
   
}
