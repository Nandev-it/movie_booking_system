<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Priority: session > authenticated user preference > browser > default
        if (session()->has('locale')) {
            $locale = session('locale');
        } elseif (Auth::check() && Auth::user()->locale) {
            $locale = Auth::user()->locale;
        } else {
            // detect browser language
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if (!in_array($locale, ['en', 'kh', 'kr', 'jp'])) {
                $locale = 'en';
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
