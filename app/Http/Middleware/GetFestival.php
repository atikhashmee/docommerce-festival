<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Festival;
use Closure;
use Illuminate\Http\Request;

class GetFestival
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = Admin::first();
        $festival = Festival::where('id', $admin->festival_id)->first();
        $request->merge(["festival" => $festival]);
        return $next($request);
    }
}
