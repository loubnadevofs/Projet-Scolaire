<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Enseignant;

class UnifiedAuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion unifié
     */
    public function showLoginForm()
    {
        return view('auth.enseignant-login');
    }

    /**
     * Traite la connexion et détermine le type d'utilisateur
     */
    public function login(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // 1. Essayer d'abord la connexion Admin (table users avec role = 'admin')
        $adminUser = User::where('email', $credentials['email'])->first();
        
        if ($adminUser && $adminUser->isAdmin() && Hash::check($credentials['password'], $adminUser->password)) {
            Auth::guard('admin')->login($adminUser, $remember);
            $request->session()->regenerate();
            
            \Log::info('Admin connecté: ' . $adminUser->email);
            
            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Si échec admin, essayer la connexion Enseignant
        if (Auth::guard('enseignant')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            \Log::info('Enseignant connecté: ' . Auth::guard('enseignant')->user()->email);
            
            return redirect()->intended(route('enseignant.dashboard'));
        }

        // 3. Si les deux échouent, retourner une erreur
        throw ValidationException::withMessages([
            'email' => ['Les informations fournies ne correspondent pas à nos enregistrements.'],
        ]);
    }

    /**
     * Déconnecte l'utilisateur (admin ou enseignant)
     */
    public function logout(Request $request)
    {
        // Vérifier quel guard est actuellement connecté et le déconnecter
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('enseignant')->check()) {
            Auth::guard('enseignant')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('accueil');
    }
}
