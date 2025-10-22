<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder a esta sección.');
        }

        // Verificar si el usuario tiene un rol asignado
        if (!auth()->user()->role) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un rol asignado. Contacta al administrador.');
        }

        // Verificar si el usuario tiene alguno de los roles requeridos
        $userRole = auth()->user()->role->name;
        
        if (!in_array($userRole, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}