<?php

namespace Database\Factories;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Competence>
 */
class CompetenceFactory extends Factory
{
    protected $model = Competence::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $competences = [
            ['nom' => 'PHP',           'categorie' => 'Backend'],
            ['nom' => 'Laravel',       'categorie' => 'Backend'],
            ['nom' => 'Python',        'categorie' => 'Backend'],
            ['nom' => 'Node.js',       'categorie' => 'Backend'],
            ['nom' => 'Java',          'categorie' => 'Backend'],
            ['nom' => 'JavaScript',    'categorie' => 'Frontend'],
            ['nom' => 'React',         'categorie' => 'Frontend'],
            ['nom' => 'Vue.js',        'categorie' => 'Frontend'],
            ['nom' => 'HTML/CSS',      'categorie' => 'Frontend'],
            ['nom' => 'Tailwind CSS',  'categorie' => 'Frontend'],
            ['nom' => 'MySQL',         'categorie' => 'Base de données'],
            ['nom' => 'PostgreSQL',    'categorie' => 'Base de données'],
            ['nom' => 'MongoDB',       'categorie' => 'Base de données'],
            ['nom' => 'Docker',        'categorie' => 'DevOps'],
            ['nom' => 'Git',           'categorie' => 'DevOps'],
            ['nom' => 'CI/CD',         'categorie' => 'DevOps'],
            ['nom' => 'AWS',           'categorie' => 'Cloud'],
            ['nom' => 'Linux',         'categorie' => 'Système'],
            ['nom' => 'REST API',      'categorie' => 'Architecture'],
            ['nom' => 'Agile/Scrum',   'categorie' => 'Méthodes'],
        ];
 
        $item = fake()->unique()->randomElement($competences);
        return [
            'nom'=>$item['nom'],
            'categorie'=>$item['categorie'],
        ];
    }
}
