<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Blokir superadmin dari akses write — superadmin hanya read-only
class NotSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if ($u && $u->role === 'superadmin') {
            if ($request->expectsJson()) return response()->json(['error' => 'Super Admin hanya dapat melihat data, tidak bisa mengubah'], 403);
            abort(403, 'Super Admin hanya dapat melihat data. Tidak dapat mengubah atau menambah data.');
        }
        return $next($request);
    }
}
