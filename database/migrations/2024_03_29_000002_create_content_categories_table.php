<?php

use App\Models\Content\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->nullable()->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('content_categories');
            $table->timestamps();
        });
        Schema::table('content_pages', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->nullable()->cascadeOnDelete();
        });

        /*** Ajout des permision **/
        $permissions = [
            [
                'category' => 'Content',
                'group_name' => 'Categories',
                'permissions' => [
                    'content.categories.create',
                    'content.categories.update',
                    'content.categories.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('content_categories');
    }
};
