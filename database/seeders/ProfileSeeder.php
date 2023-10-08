<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Perfil Tipo 1 con tasa de interés del 1%
        Profile::create([
            'nombre' => 'Tipo 1',
            'interes' => 1.00,
        ]);

        // Perfil Tipo 2 con tasa de interés del 2%
        Profile::create([
            'nombre' => 'Tipo 2',
            'interes' => 2.00,
        ]);

        // Perfil Tipo 3 con tasa de interés del 3%
        Profile::create([
            'nombre' => 'Tipo 3',
            'interes' => 3.00,
        ]);
    }

}
