<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidature extends Model
{
    use HasFactory;
    protected $fillable=[
        'profil_id',
        'offre_id',
        'message',
        'statut',
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
 
    public function scopeAcceptees($query)
    {
        return $query->where('statut', 'acceptee');
    }
 
    public function scopeRefusees($query)
    {
        return $query->where('statut', 'refusee');
    }
}
