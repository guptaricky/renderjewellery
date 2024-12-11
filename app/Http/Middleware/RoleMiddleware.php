<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
    public function handle($request, Closure $next, ...$roles)
    {
        // Log the incoming roles and authenticated user
        Log::info('RoleMiddleware invoked', [
            'roles' => $roles,
            'user_id' => Auth::id(),
            'user_roles' => Auth::check() ? Auth::user()->roles->pluck('name') : null,
        ]);

        // Check if the user is authenticated
        // if (!Auth::check()) {
        //     return redirect()->route('login'); // Redirect to login if not authenticated
        // }

        // Get the authenticated user
        $user = Auth::user();
        
        // Check if the user has the required role
        // Log::info(Auth::user());
        // Log::info(Auth::user()->hasRole($roles));
        // foreach ($roles as $role) {
            // Log::info($roles);
            if ($user && method_exists($user, 'hasRole') && $user->hasRole($roles)) {
                Log::info('checking....');
                return $next($request);
            }
        // }

        Log::warning('Unauthorized access attempt by user: ' . Auth::id());

        abort(403, 'Unauthorized.');
    }
}
