<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Offre;

class RecruteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recruteurs = User::factory(5)->create([
            'role' => 'recruteur',
        ]);

        foreach ($recruteurs as $recruteur) {
            Offre::factory(rand(2, 3))->create([
                'user_id' => $recruteur->id,
            ]);
    }
}
}
