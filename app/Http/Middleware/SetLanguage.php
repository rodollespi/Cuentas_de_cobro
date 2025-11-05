<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('lenguaje', 'es');
        App::setLocale($locale);

        return $next($request);
    }
}

