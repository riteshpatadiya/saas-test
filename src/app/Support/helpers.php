<?php

use Illuminate\Http\Request;

if (! function_exists('current_store_slug')) {
    function current_store_slug(?Request $request = null): ?string
    {
        $request = $request ?: request();

        if (! $request) {
            return null;
        }

        $routeStore = $request->route('store');

        if ($routeStore) {
            return is_string($routeStore)
                ? $routeStore
                : $routeStore->slug ?? null;
        }

        $host = $request->getHost(); 
        $baseDomain = config('app.store_domain'); 

        if (! $host || ! $baseDomain) {
            return null;
        }

        if (! str_ends_with($host, '.' . $baseDomain)) {
            return null;
        }

        return str_replace('.' . $baseDomain, '', $host);
    }
}