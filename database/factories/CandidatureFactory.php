<?php

namespace Database\Factories;

use App\Models\Candidature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Candidature>
 */
class CandidatureFactory extends Factory
{
    protected $model = Candidature::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message'=>fake()->paragraph(2),
            'statut' =>fake()->randomElement(['en_attente', 'acceptee', 'refusee']),
        ];
    }
}
