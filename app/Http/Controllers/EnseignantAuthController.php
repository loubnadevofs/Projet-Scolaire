<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enseignant;

class EnseignantAuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion pour les enseignants
     */
    public function showLoginForm()
    {
        return view('auth.enseignant-login');
    }

    /**
     * Traite la demande de connexion
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('enseignant')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('enseignant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les informations fournies ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnecte l'enseignant
     */
    public function logout(Request $request)
    {
        Auth::guard('enseignant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}