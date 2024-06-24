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
            $table->foreignId('category_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_menu')->default(0);
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('catalog_products', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->after('name')->nullable()->constrained('catalog_categories');
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
