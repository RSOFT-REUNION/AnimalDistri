<?php

use App\Models\Orders\Orders;
use App\Models\Orders\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::create('order_status', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('en attente de paiement');
            $table->timestamps();
        });

        Status::create(['status' => 'en attente de paiement']);
        Status::create(['status' => 'annulé']);
        Status::create(['status' => 'paiement accepté']);
        Status::create(['status' => 'en cours de préparation']);
        Status::create(['status' => 'prêt pour livraison']);
        Status::create(['status' => 'en cours de livraison']);
        Status::create(['status' => 'livré']);
        Status::create(['status' => 'remboursé']);

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('erp_ref_order'); // pour le lien SAP/EBP
            $table->string('payment_id')->nullable();
            $table->foreignIdFor(Status::class)->default(1)->constrained('order_status');
            $table->integer('total_ttc')->nullable();

            $table->foreignIdFor(\App\Models\Users\User::class)->constrained();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->integer('user_loyality_used')->nullable();
            $table->integer('user_loyality_points_used')->nullable();

            $table->integer('delivery_id')->nullable();
            $table->integer('delivery_price')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_slot')->nullable();

            $table->string('user_delivery_civilite')->nullable();
            $table->string('user_delivery_first_name')->nullable();
            $table->string('user_delivery_last_name')->nullable();
            $table->string('user_delivery_address')->nullable();
            $table->string('user_delivery_address2')->nullable();
            $table->string('user_delivery_cities')->nullable();
            $table->string('user_delivery_phone')->nullable();
            $table->string('user_delivery_other_phone')->nullable();

            $table->string('user_invoice_civilite')->nullable();
            $table->string('user_invoice_first_name')->nullable();
            $table->string('user_invoice_last_name')->nullable();
            $table->string('user_invoice_address')->nullable();
            $table->string('user_invoice_address2')->nullable();
            $table->string('user_invoice_cities')->nullable();
            $table->string('user_invoice_phone')->nullable();
            $table->string('user_invoice_other_phone')->nullable();

            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Orders::class)->constrained();
            $table->integer('carts_id');
            $table->integer('product_id');
            // Infor Produits
            $table->string('code_article')->nullable(); //code EBP
            $table->string('name');
            $table->string('short_description')->nullable();
            $table->string('fav_image')->nullable();
            $table->string('barcode')->nullable();
            $table->string('weight_unit')->default('kg'); // Kilogramme ou Litre
            $table->integer('weight')->default(0);
            $table->string('stock_unit')->default('unit'); // Unité de vente. valeurs possibles: soit Unité, soit Kilogramme ou Litre pour le vrac
            // Info prix produit
            $table->integer('price_ht');
            $table->enum('tva',[0, 210, 850])->default(0);
            $table->integer('price_ttc')->nullable();
            $table->integer('discount_id')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->integer('discount_fixed_price_ttc')->nullable();
            $table->integer('quantity')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        /*** Ajout des permisions **/
        $permissions = [
            [
                'category' => 'Orders',
                'group_name' => 'Orders',
                'permissions' => [
                    'orders.orders.create',
                    'orders.orders.update',
                    'orders.orders.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_status');
    }
};
