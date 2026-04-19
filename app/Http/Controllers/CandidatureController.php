<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;
class CandidatureController extends Controller
{

    public function postuler(Request $request, Offre $offre)
    {
        if (!$offre->actif) {
            return response()->json(['message' => 'Cette offre n\'est plus active.'], 422);
        }

        
        $profil = Auth::user()->profil;
        if (!$profil) {
            return response()->json(['message' => 'Vous devez créer votre profil avant de postuler.'], 422);
        }

       
        $dejaPostule = Candidature::where('offre_id', $offre->id)
            ->where('profil_id', $profil->id)
            ->exists();

        if ($dejaPostule) {
            return response()->json(['message' => 'Vous avez déjà postulé à cette offre.'], 422);
        }

        
        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        
        $candidature = Candidature::create([
            'offre_id'  => $offre->id,
            'profil_id' => $profil->id,
            'message'   => $request->message,
            'statut'    => 'en_attente',
        ]);
        event(new CandidatureDeposee($candidature));
        return response()->json([
            'message'     => 'Candidature soumise avec succès.',
            'candidature' => $candidature->load('offre'),
        ], 201);
    }

  
    public function mesCandidatures()
    {
        $profil = Auth::user()->profil;

        if (!$profil) {
            return response()->json(['message' => 'Aucun profil trouvé.'], 404);
        }

        $candidatures = Candidature::with(['offre'])
            ->where('profil_id', $profil->id)
            ->latest()
            ->paginate(10);

        return response()->json($candidatures);
    }

 
    public function candidaturesOffre(Offre $offre)
    {
  
        if ($offre->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $candidatures = Candidature::with(['profil.user', 'profil.competences'])
            ->where('offre_id', $offre->id)
            ->latest()
            ->paginate(10);

        return response()->json($candidatures);
    }


    public function changerStatut(Request $request, Candidature $candidature)
    {
       
        if ($candidature->offre->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);
$ancienStatut = $candidature->statut;
        $candidature->update(['statut' => $request->statut]);
event(new StatutCandidatureMis($candidature, $ancienStatut, $request->statut));        return response()->json([
            'message'     => 'Statut mis à jour.',
            'candidature' => $candidature->fresh()->load('profil.user', 'offre'),
        ]);
    }
}