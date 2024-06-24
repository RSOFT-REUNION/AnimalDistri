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
        Schema::create('content_carousel', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->string('description')->nullable();
            $table->string('title_url')->nullable();
            $table->string('url')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
        /*** Ajout des permision **/
        $permissions = [
            [
                'category' => 'Content',
                'group_name' => 'Carrousel',
                'permissions' => [
                    'content.carousel.create',
                    'content.carousel.update',
                    'content.carousel.delete',
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
        Schema::dropIfExists('content_carousel');
    }
};
