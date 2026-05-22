<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeoManagementAccess
{
    /**
     * Handle an incoming request - restrict SEO management to Admin and Editor roles only.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        // Check if user has admin or editor role
        if (!$user->hasAnyRole(['admin', 'editor', 'superadmin'])) {
            return response()->json(['message' => 'Forbidden - SEO management access denied'], 403);
        }

        return $next($request);
    }
}
