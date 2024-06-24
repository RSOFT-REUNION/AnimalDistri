<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('city');
            $table->string('postal_code');
            $table->string('region');
            $table->timestamps();
        });

        // Insert data
        DB::table('cities')->insert([
            ['country' => 'La Réunion', 'city' => 'Bras-Panon', 'postal_code' => '97412', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Entre-Deux', 'postal_code' => '97414', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => "L’Étang-Salé", 'postal_code' => '97427', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'La Plaine-des-Palmistes', 'postal_code' => '97431', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'La Possession', 'postal_code' => '97419', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Le Port', 'postal_code' => '97420', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Le Tampon', 'postal_code' => '97430', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Les Avirons', 'postal_code' => '97425', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Les Trois-Bassins', 'postal_code' => '97426', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Petite-Île', 'postal_code' => '97429', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-André', 'postal_code' => '97440', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Saint-Benoît', 'postal_code' => '97470', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Saint-Denis', 'postal_code' => '97400', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Sainte-Anne', 'postal_code' => '97437', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Sainte-Marie', 'postal_code' => '97438', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Sainte-Rose', 'postal_code' => '97439', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Sainte-Suzanne', 'postal_code' => '97441', 'region' => 'nord'],
            ['country' => 'La Réunion', 'city' => 'Saint-Joseph', 'postal_code' => '97480', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Leu', 'postal_code' => '97436', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Louis', 'postal_code' => '97450', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Paul', 'postal_code' => '97460', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Gilles', 'postal_code' => '97434', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Philippe', 'postal_code' => '97442', 'region' => 'sud'],
            ['country' => 'La Réunion', 'city' => 'Saint-Pierre', 'postal_code' => '97410', 'region' => 'sud'],
        ]);

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country');
    }
};
