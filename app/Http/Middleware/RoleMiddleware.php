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

        $normalizedRoles = array_map(function($r) {
            return $this->normalizeRole($r);
        }, $roles);

        if (!in_array($userRole, $normalizedRoles)) {
            abort(403, 'Anda tidak punya akses.');
        }

        return $next($request);
    }

    private function normalizeRole($role)
    {
        return Str::of($role)
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->__toString();
    }
}