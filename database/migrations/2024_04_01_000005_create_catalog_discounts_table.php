<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {

        // ** LES PROMOTIONS **
        Schema::create('catalog_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('ref_discount')->nullable();
            $table->string('name');
            $table->longText('short_description')->nullable();
            $table->string('icon')->default('star');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('percentage')->default(5);
            $table->string('discount_type')->nullable()->default('prix TTC');
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        // Les produits rattachés à chaques promotions
        Schema::create('catalog_discounts_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Catalog\Discount::class)->constrained('catalog_discounts')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Catalog\Product::class)->constrained('catalog_products');
            $table->string('erp_id')->nullable(); //code EBP
            $table->integer('fixed_priceTTC')->nullable();
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });


        /*** Ajout des permissions **/
        $permissions = [
            [
                'category' => 'Catalog',
                'group_name' => 'Discounts',
                'permissions' => [
                    'catalog.discounts.create',
                    'catalog.discounts.update',
                    'catalog.discounts.delete',
                ],
            ]
        ];
        addPermissions($permissions);

    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_discounts_products');
        Schema::dropIfExists('catalog_discounts');
    }
};
