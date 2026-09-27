<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OperatorOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role !== 'operator') {
            abort(403, 'Akses ditolak. Hanya operator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
