<?php

namespace App\Http\Middleware;

use Closure;

class Localisation
{
    const DEFAULT_LOCALE = 'en';

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
        app()->setLocale($header? $header : self::DEFAULT_LOCALE);

        return $next($request);
    }
}
