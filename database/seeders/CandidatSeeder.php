<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Profil;
use App\Models\Competence;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // créer candidats
        $candidats = User::factory(10)->create([
            'role' => 'candidat',
        ]);

        // créer compétences UNE seule fois (IMPORTANT)
        $competences = Competence::factory(5)->create();

        foreach ($candidats as $candidat) {

            // créer profil SANS factory (plus safe)
            $profil = Profil::create([
                'user_id' => $candidat->id,
                'titre' => fake()->jobTitle(),
                'bio' => fake()->paragraph(),
                'localisation' => fake()->city(),
                'disponible' => true,
            ]);

            // attacher compétences existantes
            foreach ($competences->random(3) as $competence) {
                $profil->competences()->attach($competence->id, [
                    'niveau' => fake()->randomElement([
                        'debutant',
                        'intermediaire',
                        'expert'
                    ]),
                ]);
            }
        }
    }
}