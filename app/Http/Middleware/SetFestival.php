<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetFestival
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
        if (is_null(auth()->guard('admin')->user()->festival_id)) {
            return redirect(route('admin.dashboard.setFestival'));
        }
        return $next($request);
    }
}
