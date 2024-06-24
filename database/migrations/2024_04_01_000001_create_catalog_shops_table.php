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
        Schema::create('catalog_shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->text('description')->nullable();
            $table->text('schedules')->nullable();
            $table->enum('visibility', ['privé', 'public'])->default('privé');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });


        /*** Ajout des permision **/
        $permissions = [
            [
                'category' => 'Catalog',
                'group_name' => 'Shops',
                'permissions' => [
                    'catalog.shops.create',
                    'catalog.shops.update',
                    'catalog.shops.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_shops');
    }
};
