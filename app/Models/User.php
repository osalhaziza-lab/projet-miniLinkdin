<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Notifications\Notifiable;
use App\Models\Profil;
use App\Models\Offre;




class User extends Authenticatable implements JWTSubject 

{
      use HasFactory, Notifiable;
      
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
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

    public function profil()
{
    return $this->hasOne(Profil::class);
}

public function offres()
{
    return $this->hasMany(Offre::class);
}
}


    
