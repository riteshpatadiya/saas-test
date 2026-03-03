<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;

// Models
use App\Models\Store;

class ResolveStoreFromSubdomain
{

    public function handle($request, Closure $next)
    {
        $subdomain = $request->route('store');

        $store = Store::where('slug', $subdomain)->firstOrFail();

        app()->instance('currentStore', $store);

        // 🔥 Set global route parameter default
        URL::defaults([
            'store' => $subdomain,
        ]);

        return $next($request);
    }
}
