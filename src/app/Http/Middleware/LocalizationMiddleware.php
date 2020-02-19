<?php

namespace Emotionally\Http\Middleware;

use Closure;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\Console\Output\ConsoleOutput;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accepted_locales = ['en', 'it'];
        $locale = $request->segment(1, config('app.fallback_locale'));
        if (!in_array($locale, $accepted_locales)) {
            $locale = \Session::get('locale', config('app.fallback_locale'));
        }
        \Session::put('locale', $locale);

        \App::setLocale($locale);
        return $next($request);
    }
}
