<?php

namespace App\Http\Controllers;
use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    // GET /api/offres
    public function index(Request $request)
    {
        $query = Offre::actives()
            ->with('recruteur')
            ->orderBy('created_at', 'desc');
             if ($request->filled('localisation')) {
            $query->where('localisation','like','%' . $request->localisation . '%');
        }
if ($request->filled('type')) {
            $query->where('type',$request->type);
        }

        return response()->json($query->paginate(10));
    }
     // GET /api/offres/{offre}
     public function show(Offre $offre)
    {
        return response()->json($offre->load('recruteur'));
    }
// POST /api/offres 

 public function store(Request $request)
    {
        if (auth()->user()->role!=='recruteur') {
            return response()->json(['message'=>'Acces refuse'], 403);
        }
 $validatedData = $request->validate([
            'titre'=>'required|string|max:255',
            'description'=>'required|string',
            'localisation'=>'nullable|string|max:255',
            'type'=>'required|in:CDI,CDD,stage',
        ]);

$offre = auth()->user()->offres()->create($validatedData+['actif' => true]);

        return response()->json($offre,201);
    }

// PUT /api/offres/{offre}

public function update(Request $request, Offre $offre)
    {
        if (auth()->id()!==$offre->user_id) {
            return response()->json(['message'=>'Acces refuse'], 403);
        }
 $validatedData = $request->validate([
            'titre'=>'sometimes|string|max:255',
            'description'=>'sometimes|string',
            'localisation'=>'nullable|string|max:255',
            'type'=>'sometimes|in:CDI,CDD,stage',
            'actif'=>'sometimes|boolean',
        ]);
$offre->update($validatedData);

        return response()->json($offre->fresh());
    }
// DELETE /api/offres/{offre} 
public function destroy(Offre $offre)
    {
        if (auth()->id()!==$offre->user_id) {
            return response()->json(['message'=>'Acces refuse'], 403);
        }

        $offre->delete();

        return response()->json(['message'=>'Offre supprimee.']);
    }
}
