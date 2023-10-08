<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $cedula = mt_rand(10000000, 999999999);
            $profile = mt_rand(1, 3);
            DB::table('accounts')->insert([
                'cedula' => $cedula, 
                'nombre' => 'Cuenta usuario ' . $i,
                'saldo' => rand(100, 10000) / 100,
                'profile_id' => $profile, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
