<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 👈 importer cette interface

class User extends Authenticatable implements JWTSubject // 👈 implémenter
{
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];



    // identifiant unique (l'id)
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Ajoute des données supplémentaires dans le Payload du token
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role  // on met le rôle dans le token !
        ];
    }

    // Relation avec le profil 
    public function profil()
    {
        return $this->hasOne(Profil::class);
    }
}