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

        $userRole = $request->user()->role ? $request->user()->role->slug : 'user';

        if (! in_array($userRole, $roles)) {
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
