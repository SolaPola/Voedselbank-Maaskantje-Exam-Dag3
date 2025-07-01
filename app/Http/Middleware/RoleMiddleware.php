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
        
        // Debug logging
        Log::info('Role Middleware Debug', [
            'user_id' => $user->id,
            'user_roles' => $userRoles,
            'required_roles' => $roles,
            'user_email' => $user->email
        ]);

        // Convert string roles to integers and check
        foreach ($roles as $role) {
            $roleId = (int) $role;
            if (in_array($roleId, $userRoles)) {
                return $next($request);
            }
        }

        // If no roles match, return 403
        Log::warning('Unauthorized access attempt', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'required_roles' => $roles,
            'user_roles' => $userRoles,
            'url' => $request->url()
        ]);

        abort(403, 'Unauthorized access - Required roles: ' . implode(', ', $roles) . '. User roles: ' . implode(', ', $userRoles));
    }
}
