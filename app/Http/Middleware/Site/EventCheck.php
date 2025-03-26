<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $myEvent = Auth::user()->event;

        view()->share([
            'myEvent' => $myEvent,
        ]);

        return $next($request);
    }
}
