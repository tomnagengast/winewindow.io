<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XFrameOptions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);

        $response->header('X-Frame-Options', 'ALLOW-FROM https://bajkawine.com https://cinquaincellars.com');
//        $response->header('X-Frame-Options', 'ALLOW-FROM SAMEORIGIN');

        return $response;
    }
}
