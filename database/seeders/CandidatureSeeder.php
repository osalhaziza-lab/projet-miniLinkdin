<?php

namespace Database\Seeders;
use App\Models\Candidature;
use App\Models\Profil;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Competence;

class CandidatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profils = Profil::all();
        $offres = Offre::all();

        foreach ($profils as $profil) {

            foreach ($offres->random(2) as $offre) {

                Candidature::create([
                    'profil_id'=>$profil->id,
                    'offre_id'=>$offre->id,
                    'message'=>fake()->paragraph(),
                    'statut'=>'en_attente',
                ]);
            }
        }
    }
}