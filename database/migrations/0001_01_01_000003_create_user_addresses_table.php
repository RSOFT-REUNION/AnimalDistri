<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Users\User::class)->constrained();
            $table->string('alias');
            $table->enum('civility', ['Mr', 'Mme'])->default('Mr');
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('other')->nullable();
            $table->string('cities')->nullable();
            $table->string('country')->default('La Réunion');
            $table->string('phone')->nullable();
            $table->string('other_phone')->nullable();
            $table->enum('type', ['Facturation et livraison', 'Facturation', 'Livraison'])->default('Facturation et livraison');
            $table->string('favorite')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
