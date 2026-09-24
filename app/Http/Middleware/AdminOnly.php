<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Superadmin (read only), admin_city, dan operator boleh lewat; user biasa ditolak 403.
// Catatan: Superadmin hanya read-only — akses write diatur di controller.
class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if (!$u || !in_array($u->role, ['superadmin', 'admin_city', 'operator'], true)) {
            if ($request->expectsJson()) return response()->json(['error' => 'Akses ditolak'], 403);
            abort(403, 'Akses ditolak. Akun User hanya dapat melihat data.');
        }
        return $next($request);
    }
}
