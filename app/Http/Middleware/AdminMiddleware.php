<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || strtolower(auth()->user()->role) !== 'admin') {
            // Kalau request dari API, kembalikan JSON bukan halaman 403
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Hanya admin.'], 403);
            }

            abort(403, 'AKSES DITOLAK!');
        }

        return $next($request);
    }
}
