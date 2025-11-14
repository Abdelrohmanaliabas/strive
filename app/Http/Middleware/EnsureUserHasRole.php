<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):(\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'This action is unauthorized.');
        }

        $expectedRoles = collect($roles)
            ->flatMap(fn (string $role) => explode('|', $role))
            ->filter()
            ->map(fn (string $role) => strtolower(trim($role)))
            ->values();

    

        $userRole = strtolower((string) $user->role);

        if (! $expectedRoles->contains($userRole)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
