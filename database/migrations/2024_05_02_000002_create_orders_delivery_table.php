<?php

use App\Models\Orders\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_delivery', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('price_ttc')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        /*** Ajout des permisions **/
        $permissions = [
            [
                'category' => 'Commande',
                'group_name' => 'Livraison',
                'permissions' => [
                    'orders.delivery.create',
                    'orders.delivery.update',
                    'orders.delivery.delete',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('order_delivery');
    }
};
