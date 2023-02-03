<?php

if (!function_exists('set_active')) {
    function set_active($uri)
    {
        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) { // jika route sekarang sama dengan variable u
                    return 'active';
                }
            }
        } else {
            if (Route::is($uri)) { // jika route sekarang sama dengan variable u
                return 'active';
            }
        }
        // return request()->routeIs($uri) ? 'active' : '';
    }
}
