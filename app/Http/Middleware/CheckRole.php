<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * If user is not auth
         */
        if ($request->user() === null) {
            return redirect()->route('home');
        }

        /**
         * Get array from routes
         */
        $actions = $request->route()->getAction();

        /**
         * Find if there is some roles for the route
         */
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        /**
         * Check if user has any of roles or if roles dont set for this route
         */
        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        return redirect()->route('home');
    }
}
