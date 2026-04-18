<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function listeUsers()
    {
        $users = User::with('profil')
            ->latest()
            ->paginate(15);

        return response()->json($users);
    }
    public function supprimerUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json([
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ], 422);
        }
        $user->delete();
        return response()->json([
            'message' => 'Compte supprimé avec succès.'
        ]);
    }

    public function toggleOffre(Offre $offre)
    {
        $offre->update(['actif' => !$offre->actif]);

        $etat = $offre->actif ? 'activée' : 'désactivée';

        return response()->json([
            'message' => "Offre {$etat} avec succès.",
            'offre'   => $offre->fresh(),
        ]);
    }
}
