<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('enseignant/*')) {
                return route('enseignant.login');
            } elseif ($request->is('formateur/*')) {
                return route('formateur.login');
            } else {
                return route('enseignant.login');
            }
        }
    }
}