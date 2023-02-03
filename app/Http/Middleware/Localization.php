<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        //ambil session local default en
        if (session()->has('locale')){
            \App::setlocale(session()->get('locale'));
        }
        return $next($request);
    }
}
