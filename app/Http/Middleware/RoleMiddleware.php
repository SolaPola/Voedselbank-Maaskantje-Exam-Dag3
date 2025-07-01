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
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        // Load roles if not already loaded
        $user->load('roles');
        
        $userRoles = $user->roles->pluck('id')->toArray();
        
        // Parse roles - handle comma-separated roles like "1,2"
        $allowedRoles = [];
        foreach ($roles as $role) {
            if (strpos($role, ',') !== false) {
                $allowedRoles = array_merge($allowedRoles, explode(',', $role));
            } else {
                $allowedRoles[] = $role;
            }
        }
        
        // Convert to integers
        $allowedRoles = array_map('intval', $allowedRoles);
        
        // Debug logging
        Log::info('Role Middleware Debug', [
            'user_id' => $user->id,
            'user_roles' => $userRoles,
            'allowed_roles' => $allowedRoles,
            'user_email' => $user->email
        ]);

        // Check if user has any of the allowed roles
        foreach ($allowedRoles as $roleId) {
            if (in_array($roleId, $userRoles)) {
                return $next($request);
            }
        }

        // If no roles match, return 403
        Log::warning('Unauthorized access attempt', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'allowed_roles' => $allowedRoles,
            'user_roles' => $userRoles,
            'url' => $request->url()
        ]);

        abort(403, 'Unauthorized access - Required roles: ' . implode(', ', $allowedRoles) . '. User roles: ' . implode(', ', $userRoles));
    }
}
