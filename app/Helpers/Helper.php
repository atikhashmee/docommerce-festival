<?php


if (!function_exists('getFestival')) {
    function getFestival()
    {
        $admin = \App\Models\Admin::first();
        return \App\Models\Festival::where('id', $admin->festival_id)->first();
    }
}

if ( ! function_exists('dateFormat')) {
    function dateFormat($date, $time = null)
    {
        if ($time) {
            return date('d M, Y h:i A', strtotime("+6 hours" . $date));
        } else {
            return date('d M, Y', strtotime("+6 hours" . $date));
        }
    }
}

if ( ! function_exists('pagiSerial')) {
    function pagiSerial($data, $perPage)
    {
        $page = request()->page ?? 1;
        $start = $perPage * ($page-1);
        return $data->total() - $start;
    }
}

