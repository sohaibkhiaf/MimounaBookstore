<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user has a language cookie
        if ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
        } else {
            // use browser preferred language if cookie not set
            $locale = $request->getPreferredLanguage(['en', 'ar', 'fr']);
        }

        // set app locale
        App::setLocale($locale);

        return $next($request);
    }
}
