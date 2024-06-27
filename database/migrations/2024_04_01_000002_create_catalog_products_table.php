<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->string('erp_id')->nullable(); //code EBP
            $table->string('name');
            $table->string('slug')->nullable();
            // category_id   -  généré par la migration catalog_categories: $table->foreignId(category_id)->nullable();
            // généré par la migration catalog_brands: $table->foreignId('brand_id')->nullable();
            $table->string('fav_image')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('composition')->nullable();
            $table->longText('constituants')->nullable();
            $table->longText('mode_emploi')->nullable();
            $table->longText('additifs')->nullable();
            $table->string('tags')->nullable();
            $table->longText('barcode')->nullable();
            $table->string('weight_unit')->default('kg'); // kg ou l
            $table->integer('weight')->default(0);
            $table->integer('price_ht');
            $table->integer('tva')->default(0);
            $table->integer('price_ttc')->nullable();
            $table->integer('stock')->default(0); // "stock réel"
            $table->string('stock_unit')->default('unit'); // Unité de vente. valeurs possibles: soit Unité, soit Kilogramme ou Litre pour le vrac
            $table->boolean('active')->default(1);
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by_id')->nullable();
        });

        /*** Ajout des permissions **/
        $permissions = [
            [
                'category' => 'Catalog',
                'group_name' => 'Products',
                'permissions' => [
                    'catalog.products.create',
                    'catalog.products.update',
                    'catalog.products.delete',
                ],
            ]
        ];
        addPermissions($permissions);

    }


    public function down(): void
    {
        Schema::dropIfExists('catalog_products');
    }
};
