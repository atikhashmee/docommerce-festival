<?php

namespace App\Http\Controllers\Admin;

use App\Models\Festival;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index() {
       return redirect(route('admin.login'));
    }

    public function dashboard() {
        $data = [];
        return view('admin.dashboard', $data);
    }

    public function setFestival(Request $request) {
        $data = [];
        $today = date('Y-m-d h:i:s');
        $data['festivals'] = Festival::select('*')
        // ->whereDate('festivals.start_at','<=', $today)
        // ->whereDate('festivals.end_at','>=', $today)
        ->get();
        return view('admin.set-festival', $data);
    }

    public function postFestival(Request $request) {
        Admin::whereNotNull('id')->update(['festival_id' => $request->festival_id]);
        return redirect()->back()->withSuccess('Festival has been set');
    }
}
