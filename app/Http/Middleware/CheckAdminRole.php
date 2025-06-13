<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check() || !Auth::guard('admin')->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
