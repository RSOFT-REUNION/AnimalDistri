<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Catalog\Brand;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalog_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('short_description')->nullable();
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('catalog_products', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Catalog\Brand::class)->nullable()->after('name')->constrained('catalog_brands');
        });


        /*** Ajout des permision **/
        $permissions = [
            [
                'category' => 'Catalog',
                'group_name' => 'Brands',
                'permissions' => [
                    'catalog.brands.create',
                    'catalog.brands.update',
                    'catalog.brands.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_brands');
    }
};
