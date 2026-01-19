<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak punya akses.');
        }

        // Validasi role-specific records di database
        // Role guru harus punya record di tabel gurus
        if (in_array('guru', $roles) && $userRole === 'guru') {
            if (!$user->guru) {
                abort(403, 'Anda bukan guru.');
            }
        }

        // Role walikelas harus punya record di tabel gurus dengan status wali kelas
        if (in_array('walikelas', $roles) && $userRole === 'walikelas') {
            if (!$user->guru) {
                abort(403, 'Anda bukan wali kelas.');
            }
        }

        return $next($request);
    }
}
