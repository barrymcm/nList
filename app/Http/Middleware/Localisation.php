<?php

namespace App\Http\Middleware;

use Closure;

class Localisation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $header = $request->header('X-localisation');
        app()->setLocale($header?: app()->getLocale());

        return $next($request);
    }
}
