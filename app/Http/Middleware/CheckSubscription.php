<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        if (env('SOFTWARE_ACTIVE', true) == false) {
         return response()->view('subscription-expired', [], 403);
       }

        return $next($request);
    }
}