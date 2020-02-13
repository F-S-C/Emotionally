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
     * @param string $permission_required The required permission. Must be one
     * of: 'read', 'modify', 'add', 'remove' (case unsensitive).
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_required)
    {
        $can_read_project = $request->user()
            ->permissions
            ->where('id', $request->route()->parameters()['id'])
            ->where($permission_required, true)
            ->isEmpty();

        if ($can_read_project) {
            // TODO: Create error page?
            return redirect(route('system.home'));
        }

        return $next($request);
    }
}
