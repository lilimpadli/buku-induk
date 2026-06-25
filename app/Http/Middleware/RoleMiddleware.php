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
        $userRole = strtolower(trim($user->role));
        
        // --- PERBAIKAN: Menambahkan logika "alias" ---
        // Jika user adalah 'tu_kepegawaian', kita perlakukan seolah-olah dia memiliki role 'tu'
        if ($userRole === 'tu_kepegawaian') {
            $userRole = 'tu';
        }
        // ---------------------------------------------

        $allowedRoles = array_map(function($role) {
            return strtolower(trim($role));
        }, $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Akses ditolak! Role Anda saat ini adalah: "' . $user->role . '" sedangkan yang diizinkan adalah: ' . implode(', ', $allowedRoles));
        }

        // Validasi role-specific records
        if (in_array('guru', $allowedRoles) && $userRole === 'guru') {
            if (!$user->guru) {
                abort(403, 'Anda bukan guru.');
            }
        }

        if (in_array('walikelas', $allowedRoles) && $userRole === 'walikelas') {
            if (!$user->guru) {
                abort(403, 'Anda bukan wali kelas.');
            }
        }

        return $next($request);
    }
}