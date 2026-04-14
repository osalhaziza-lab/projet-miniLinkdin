<?php

namespace Database\Factories;

use App\Models\Offre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offre>
 */
class OffreFactory extends Factory
{
    protected $model=Offre::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titres=[
            'Développeur Laravel Senior',
            'Ingénieur Full Stack React/Node',
            'Développeur PHP Junior',
            'Architecte Solutions Cloud',
            'Data Engineer',
            'DevOps Engineer',
            'Développeur Mobile Flutter',
            'Analyste Business Intelligence',
            'Chef de Projet Digital',
            'Développeur Frontend Vue.js',
        ];
        return [
            'titre'=>fake()->randomElement($titres),
            'description'=>fake()->paragraphs(3,true),
            'localisation'=>fake()->randomElement(['Casablanca', 'Rabat', 'Marrakech', 'Agadir', 'Remote']),
            'type'=>fake()->randomElement(['CDI', 'CDD', 'stage']),
            'actif'=>true,
        ];
    }
}
