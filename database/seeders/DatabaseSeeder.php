<?php

namespace Database\Seeders;

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SuperAdminSeeder::class,
        ]);
        User::create([
            'name' => 'Vienne Ludovic',
            'first_name' => 'Ludovic',
            'last_name' => 'Vienne',
            'email' => 'technique@rsoft.re',
            'password' => Hash::make('pMg59f!*4D'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Amélie Comte',
            'first_name' => 'Amélie',
            'last_name' => 'Comte',
            'email' => 'dev@rsoft.re',
            'password' => Hash::make('@Amc$2024**'),
            'email_verified_at' => now(),
        ]);
    }
}
