<?php

namespace Emotionally\Http\Middleware;

use Closure;
use Emotionally\User;

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
        $has_permission = $request->user()
            ->permissions()
            ->where('id', $request->route()->parameters()['id'])
            ->wherePivot($permission_required, true)
            ->get()
            ->isNotEmpty();

        if (!$has_permission) {
            return abort(403);
        }

        return $next($request);
    }
}
