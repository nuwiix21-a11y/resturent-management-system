<?php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Checks if the authenticated user has the required role.
     * Usage in routes: ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json([
                'message' => 'Access denied. Insufficient permissions.'
            ], 403);
        }
        return $next($request);
    }
}


// ── Register middleware in bootstrap/app.php (Laravel 11) ──
// Add this inside withMiddleware() in bootstrap/app.php:
//
//   $middleware->alias([
//       'role' => \App\Http\Middleware\CheckRole::class,
//   ]);
//
// ── For Laravel 10, add to app/Http/Kernel.php ─────────────
// In $routeMiddleware array:
//
//   'role' => \App\Http\Middleware\CheckRole::class,
