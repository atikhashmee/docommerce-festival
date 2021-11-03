<?php


if (!function_exists('getFestival')) {
    function getFestival()
    {
        $admin = \App\Models\Admin::first();
        return \App\Models\Festival::where('id', $admin->festival_id)->first();
    }
}

