<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Handle cases where Laravel passes "admin,manager" as a single string
        if (count($roles) === 1 && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }

        $userRole = strtolower(trim($request->user()->role ?? ''));
        $allowedRoles = array_map('strtolower', array_map('trim', $roles));

        if (! in_array($userRole, $allowedRoles)) {
            abort(403, "Access Denied: Your current role ({$userRole}) does not have permission to view this page.");
        }

        return $next($request);
    }
}
