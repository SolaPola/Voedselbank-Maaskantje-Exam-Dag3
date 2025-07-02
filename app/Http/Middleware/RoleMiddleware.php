<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Comma-separated list of allowed roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect('login');
        }

        // Convert comma-separated roles to array
        $allowedRoles = explode(',', $roles);
        
        // Get user roles with explicit table prefix
        $userRoles = \DB::table('role_per_users')
            ->where('user_id', $user->id)
            ->pluck('role_id')
            ->toArray();
        
        // Check if user has any of the required roles
        foreach ($allowedRoles as $role) {
            if (in_array((int)$role, $userRoles)) {
                return $next($request);
            }
        }
        
        // If we get here, the user doesn't have any of the required roles
        // Return a 403 Unauthorized response
        return abort(403, 'Unauthorized action.');
    }
}
