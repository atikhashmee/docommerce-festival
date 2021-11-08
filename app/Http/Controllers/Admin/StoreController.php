<?php

namespace App\Http\Controllers\Admin;

use App\Models\Festival;
use Illuminate\Http\Request;
use App\Models\StoreFestival;
use App\Http\Controllers\Crud;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Validator;

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

    public function bulkAttachtoFestival(Request $request) {
        if ($request->type == 'bulk') {
            $storids = json_decode($request->store_ids, true);
            $storids = collect($storids)->filter(function($item) {return $item !=null;});
        } else {
            $store_id = $request->store_id;
        }
      
        try {
            $festival = $request->festival;
            if ($festival) {
                if ($request->type == 'bulk') {
                    $festival->stores()->toggle($storids);
                } else {
                    $festival->stores()->toggle([$store_id]);
                } 
            }
            return response()->json(['status' => true, 'data'=> "Data has been attached"]);
        } catch (\Exception $e) {       
            return response()->json(['status' => false, 'data'=> $e->getMessage()]);
        }
    }


    public function indexQuery(Request $request, $query) {
        $query->addSelect('store_festivals.store_id as attached_store_id', 'store_festivals.img as upload_image');
        return $query->leftJoin('store_festivals', function($q) use($request) {
            $q->on('store_festivals.store_id', '=', 'stores.id');
            $q->where('store_festivals.festival_id', $request->festival->id);
        });
    }

    public function attachImage(Request $request)
    {
        $festival = $request->festival;
        $validator = Validator::make($request->all(), [
            'store_id' => ['required', Rule::exists('store_festivals')->where(function ($query) use($festival, $request) {
                return $query->where([
                    'festival_id' => $festival->id,
                    'store_id' => $request->store_id
                ]);
            })],
            'imageFile' => 'required|file'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->hasFile('imageFile')) {
                $image = (new MediaController())->imageUpload($request->file('imageFile'), 'stores');
                $data['image'] = $image['name'];
                $stored = StoreFestival::where([
                    'festival_id' => $festival->id,
                    'store_id' =>  $request->store_id,
                ])->update(['img' => $image['name']]);
                return redirect()->back()->with('success', 'image uploaded successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
   
}
