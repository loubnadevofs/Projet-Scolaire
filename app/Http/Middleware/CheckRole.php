<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifiez si l'utilisateur a le rôle requis
        // Exemple simple, à adapter selon votre système d'authentification
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return redirect('/')->with('error', 'Accès non autorisé.');
        }
        
        return $next($request);
    }
}