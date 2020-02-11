<?php

namespace Emotionally\Http\Middleware;

use Closure;

class PermissionsMiddleware
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
        $can_read_project = $request->user()
            ->permissions
            ->where('id', $request->route()->parameters()['id'])
            ->where('read', true)
            ->isEmpty();

        if ($can_read_project) {
            // TODO: Create error page?
            return redirect(route('system.home'));
        }

        return $next($request);
    }
}
