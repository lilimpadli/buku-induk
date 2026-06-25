<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $this->normalizeRole($user->role);

        // Normalize allowed roles passed to middleware
        $normalizedRoles = array_map(function($r) {
            return $this->normalizeRole($r);
        }, $roles);

        if (!in_array($userRole, $normalizedRoles)) {
            abort(403, 'Anda tidak punya akses.');
        }

        // Validasi role-specific records di database
        // Role guru harus punya record di tabel gurus
        if (in_array('guru', $normalizedRoles) && $userRole === 'guru') {
            if (!$user->guru) {
                abort(403, 'Anda bukan guru.');
            }
        }

        // Role walikelas harus punya record di tabel gurus dengan status wali kelas
        if (in_array('walikelas', $normalizedRoles) && $userRole === 'walikelas') {
            if (!$user->guru) {
                abort(403, 'Anda bukan wali kelas.');
            }
        }

        return $next($request);
    }

    /**
     * Normalize role string to a canonical form (lowercase, underscores)
     */
    private function normalizeRole($role)
    {
        return Str::of($role)
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->__toString();
    }
}
