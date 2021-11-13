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

