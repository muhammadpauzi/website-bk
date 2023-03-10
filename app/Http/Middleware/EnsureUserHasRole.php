<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            // if ($role === "SUPERADMIN" && auth()->user()->isAdmin()) return $next($request);

            if ($request->user()->role === strtolower($role)) {
                return $next($request);
            }
        }

        // return abort(403);
        return redirect()->route('dashboard.index')->with('failed', 'Kamu tidak memilik izin untuk mengakses halaman tersebut.');
    }
}
