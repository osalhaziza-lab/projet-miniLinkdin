<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // =============================================
    // REGISTER — Créer un nouveau compte
    // =============================================
    public function register(Request $request)
    {
        // 1. Valider les données reçues
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:candidat,recruteur', // admin ne peut pas s'inscrire seul
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 = données invalides
        }

        // 2. Créer l'utilisateur en base
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hacher le mot de passe !
            'role'     => $request->role,
        ]);

        // 3. Générer le token JWT pour cet utilisateur
        $token = auth()->login($user);

        return response()->json([
            'message' => 'Compte créé avec succès',
            'user'    => $user,
            'token'   => $token,
        ], 201); // 201 = ressource créée
    }

    // =============================================
    // LOGIN — Se connecter
    // =============================================
    public function login(Request $request)
    {
        // 1. Valider
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Tenter l'authentification
        // auth()->attempt() vérifie email + password ET génère un token si ok
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401); // 401 = non authentifié
        }

        return response()->json([
            'message' => 'Connecté avec succès',
            'token'   => $token,
            'user'    => auth()->user(),
        ]);
    }

    // =============================================
    // ME — Voir son propre profil utilisateur
    // =============================================
    public function me()
    {
        // auth()->user() retourne l'utilisateur connecté grâce au token
        return response()->json(auth()->user());
    }

    // =============================================
    // LOGOUT — Se déconnecter
    // =============================================
    public function logout()
    {
        auth()->logout(); // invalide le token côté serveur
        return response()->json(['message' => 'Déconnecté avec succès']);
    }

    // =============================================
    // REFRESH — Renouveler le token (avant expiration)
    // =============================================
    public function refresh()
    {
        // Génère un nouveau token à partir de l'ancien
        $newToken = auth()->refresh();
        return response()->json(['token' => $newToken]);
    }
}