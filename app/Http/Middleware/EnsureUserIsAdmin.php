<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        if (! $user->is_active) {
            abort(403, 'Akun tidak aktif.');
        }

        if (! $user->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
