<?php

namespace Database\Seeders;

use App\Models\Settings\Teams\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Administrator User
        $superAdmin = Administrator::create([
            'name' => 'Vienne Ludovic',
            'email' => 'technique@rsoft.re',
            'password' => Hash::make('pMg59f!*4D')
        ]);
        $superAdmin->assignRole('SuperAdmin');

        $superAdmin = Administrator::create([
            'name' => 'COMTE Amelie',
            'email' => 'dev@rsoft.re',
            'password' => Hash::make('@Amc$2024**')
        ]);
        $superAdmin->assignRole('SuperAdmin');

        // Creating Administrator User
        $admin = Administrator::create([
            'name' => 'Administrator',
            'email' => 'admin@rsoft.re',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('Administrateur');
    }
}
