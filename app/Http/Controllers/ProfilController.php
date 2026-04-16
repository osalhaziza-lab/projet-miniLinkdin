<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competence;
use App\Models\User;  
 

class ProfilController extends Controller
{
    // POST /api/profil
    public function store(Request $request)
{
$user=auth()->user();
if ($user->role !== 'candidat') {
            return response()->json(['message'=>'Acces refuse.'], 403);
        }
if ($user->profil) {
            return response()->json(['message'=>'Vous avez déjà un profil.'], 422);
        }
$validatedData = $request->validate([
            'titre'=>'required|string|max:255',
            'bio'=>'nullable|string',
            'localisation'=>'nullable|string|max:255',
            'disponible'=>'nullable|boolean',
           
        ]);
          $profil = $user->profil()->create($validatedData);

         return response()->json($profil, 201);  }


// GET /api/profil 
public function show(){
    $user=auth()->user();
   if ($user->role !== 'candidat') {
            return response()->json(['message'=>'Acces refuse.'], 403);
        }
if (!$user->profil) {
    return response()->json(['message'=>'Profil introuvable.'], 404);
}


 return response()->json($user->profil->load('competences'));
}
 // PUT /api/profil
public function update(Request $request){
    $user=auth()->user();
   if ($user->role !== 'candidat') {
            return response()->json(['message'=>'Acces refuse.'], 403);
        }
if (!$user->profil) {
            return response()->json(['message'=>'Vous n\'avez pas de profil.'], 404);
        }
$validatedData = $request->validate([
            'titre'=>'sometimes|string|max:255',
            'bio'=>'nullable|string',
            'localisation'=>'nullable|string|max:255',
            'disponible'=>'nullable|boolean',
           
        ]);
          $user->profil->update($validatedData);

         return response()->json($user->profil->fresh(), 200);  }


// POST /api/profil/competences 
public function addCompetence(Request $request){
    $user=auth()->user();
   if ($user->role !== 'candidat') {
            return response()->json(['message'=>'Acces refuse.'], 403);
        }
if (!$user->profil) {
            return response()->json(['message'=>'Vous n\'avez pas de profil.'], 422);
        }
$validatedData = $request->validate([
            'competence_id'=>'required|exists:competences,id',
            'niveau'=>'required|in:debutant,intermediaire,avance'
           
        ]);
          $existe=$user->profil->competences()
            ->where('competence_id', $validatedData['competence_id'])
            ->exists();
 if ($existe) {
            return response()->json(['message'=>'Competence deja ajoutee'], 422);
        }
        $user->profil->competences()->attach($validatedData['competence_id'],[
            'niveau' => $validatedData['niveau']
        ]);
         return response()->json($user->profil->load('competences'), 201);
}
// DELETE /api/profil/competences/{competence}
public function removeCompetence($competence_id){
    $user=auth()->user();
   if ($user->role !== 'candidat') {
            return response()->json(['message'=>'Acces refuse.'], 403);
        }
if (!$user->profil) {
            return response()->json(['message'=>'Vous n\'avez pas de profil.'], 404);
        }
$user->profil->competences()->detach($competence_id);
 return response()->json(['message' => 'Competence retiree du profil.'], 200);



}


}