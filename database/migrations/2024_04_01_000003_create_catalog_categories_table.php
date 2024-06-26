<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Catalog\Category;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('erp_id_famille')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->foreignId('category_id')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_menu')->default(0);
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('catalog_products_categories', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Catalog\Product::class)->constrained('catalog_products')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Catalog\Category::class)->constrained('catalog_categories')->cascadeOnDelete();
            $table->primary(['product_id', 'category_id']);
        });
        /*** Ajout des permissions **/
        $permissions = [
            [
                'category' => 'Catalog',
                'group_name' => 'Category',
                'permissions' => [
                    'catalog.categories.create',
                    'catalog.categories.update',
                    'catalog.categories.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_categories');
    }
};
