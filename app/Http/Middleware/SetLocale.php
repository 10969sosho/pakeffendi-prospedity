<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prioritaskan session, lalu cookie, lalu default config
        $locale = session('locale') 
            ?? $request->cookie('locale') 
            ?? config('app.locale');
        
        // Validasi locale
        if (!in_array($locale, ['en', 'fr', 'id'])) {
            $locale = config('app.locale');
        }
        
        app()->setLocale($locale);
        
        return $next($request);
    }
}
