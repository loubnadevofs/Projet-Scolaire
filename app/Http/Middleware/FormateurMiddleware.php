<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormateurMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté et est un formateur
        if (!Auth::check() || !Auth::user() instanceof \App\Models\Enseignant) {
            return redirect('/')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}