<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role ? strtolower(trim($request->user()->role->slug)) : 'user';

        // Parse and normalize roles (handle comma-separated lists and casing/whitespace)
        $parsedRoles = [];
        foreach ($roles as $role) {
            if (str_contains($role, ',')) {
                foreach (explode(',', $role) as $r) {
                    $parsedRoles[] = strtolower(trim($r));
                }
            } else {
                $parsedRoles[] = strtolower(trim($role));
            }
        }

        if (! in_array($userRole, $parsedRoles)) {
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.');
            } elseif ($userRole === 'staff') {
                return redirect()->route('staff.dashboard')->with('error', 'Unauthorized access.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
