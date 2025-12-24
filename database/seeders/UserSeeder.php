<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BureauVote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@election.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'telephone' => '+225 00 00 00 00 00',
        ]);

        // Créer quelques représentants de test
        $bureaux = BureauVote::with('lieuVote')->take(5)->get();
        
        foreach ($bureaux as $index => $bureau) {
            $representant = User::create([
                'name' => 'Représentant ' . ($index + 1) . ' - ' . $bureau->lieuVote->nom,
                'email' => 'representant' . ($index + 1) . '@election.com',
                'password' => Hash::make('representant123'),
                'role' => 'representant',
                'telephone' => '+225 00 00 00 00 0' . ($index + 1),
            ]);

            // Assigner le bureau au représentant
            $representant->bureauxVote()->attach($bureau->id);
        }
    }
}
