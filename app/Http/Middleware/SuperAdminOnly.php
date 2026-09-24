<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Hanya superadmin (role superadmin)
class SuperAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if (!$u || $u->role !== 'superadmin') {
            if ($request->expectsJson()) return response()->json(['error' => 'Hanya Super Admin yang dapat mengakses ini'], 403);
            abort(403, 'Hanya Super Admin yang dapat mengakses ini.');
        }
        return $next($request);
    }
}
