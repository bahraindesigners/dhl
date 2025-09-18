<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, fall back to browser preference or default
        $locale = Session::get('locale');

        if (! $locale) {
            // Try to detect from browser Accept-Language header
            $browserLang = $request->getPreferredLanguage(['en', 'ar']);
            $locale = $browserLang ?: 'en';
            Session::put('locale', $locale);
        }

        // Set the application locale
        App::setLocale($locale);

        // Share locale with Inertia for dynamic content
        Inertia::share('locale', $locale);

        return $next($request);
    }
}
