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
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        $userRole = auth()->user()->rol->nombre_rol;

        if (!in_array($userRole, $roles)) {
            abort(403, 'No tienes permisos para acceder a la seccioón.');
        }
        
        return $next($request);
    }
}
