<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('session_id');
            $table->string('payment_id')->nullable();
            $table->boolean('merged')->default(false);
            $table->string('loyality');
            $table->enum('status', ['En cours', 'Abandonner', 'Commander'])->default('En cours');
            $table->string('total_ttc')->nullable();
            $table->string('delivery_id')->nullable();
            $table->string('delivery_price')->nullable();
            $table->string('postal_code')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_slot')->nullable();
            $table->string('user_address_delivery')->nullable();
            $table->string('user_address_invoice')->nullable();
            $table->timestamps();
        });
        Schema::create('carts_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Catalog\Product::class)->constrained('catalog_products');
            $table->foreignIdFor(\App\Models\Carts\Carts::class)->constrained();
            $table->string('fav_image')->nullable();
            $table->integer('discount_id')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->integer('discount_fixed_price_ttc')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('price_ht')->default(0);
            $table->integer('tva')->default(0);
            $table->string('stock_unit')->default('unit'); // Unité de vente. valeurs possibles: soit Unité, soit Kilogramme ou Litre pour le vrac
            $table->integer('price_ttc')->default(0);
            $table->timestamps();
        });

        /*** Ajout des permisions **/
        $permissions = [
            [
                'category' => 'Clients',
                'group_name' => 'Paniers',
                'permissions' => [
                    'clients.carts.show',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('carts_product');
        Schema::dropIfExists('carts');
    }
};
