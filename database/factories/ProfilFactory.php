<?php

namespace Database\Factories;

use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profil>
 */
class ProfilFactory extends Factory
{
    protected $model = Profil::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titres = [
            'Développeur Full Stack',
            'Développeur Backend Laravel',
            'Développeur Frontend React',
            'Ingénieur DevOps',
            'Data Scientist',
            'Chef de Projet IT',
            'Analyste Fonctionnel',
            'UX/UI Designer',
            'Architecte Cloud',
            'Administrateur Système',
        ];
        return [
            'titre'=>fake()->randomElement($titres),
            'description'=>fake()->paragraph(3),
            'bio'=>fake()->paragraph(3),
            'localisation'=>fake()->city() . ', Maroc',
            'disponible'=>fake()->boolean(75),
        ];
    }
}
