<?php
use App\Http\Controllers\Frontend\ShoppingCart\CartController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::get('mon-panier', [CartController::class, 'index'])->name('cart.index');
Route::post('select_slot/{product}', [CartController::class, 'select_slot'])->name('cart.select_slot')->where(['product' => $idRegex]);
Route::get('/cart/count-product', [App\Http\Controllers\Frontend\ShoppingCart\CartController::class, 'count_product_json']);


/*** Plus utiliser, Peut etre utilise pour un autre site.
Route::post('mon-panier/down_quantity_product/{produit}', [CartController::class, 'down_quantity_product'])->name('cart.down_quantity_product')->where(['produit' => $idRegex]);
Route::post('mon-panier/up_quantity_product/{produit}', [CartController::class, 'up_quantity_product'])->name('cart.up_quantity_product')->where(['produit' => $idRegex]);
 * ***/
Route::post('mon-panier/update_quantity_product/{product}', [CartController::class, 'update_quantity_product'])->name('cart.update_quantity_product')->where(['product' => $idRegex]);
Route::get('mon-panier/delete_product/{produit}', [CartController::class, 'delete_product'])->name('cart.delete_product')->where(['produit' => $idRegex]);
Route::post('mon-panier/add_product/{produit}', [CartController::class, 'add_product'])->name('cart.add_product')->where(['produit' => $idRegex]);

Route::post('mon-panier/mon-adresse', [CartController::class, 'chose_address'])->name('cart.chose_address');
Route::post('mon-panier/mon-adresse/create_address', [CartController::class, 'create_address'])->name('cart.create_address');
Route::post('mon-panier/livraison', [CartController::class, 'chose_delivery'])->name('cart.chose_delivery');
Route::post('mon-panier/livraison/{deliver}', [CartController::class, 'chosed_delivery'])->name('cart.chosed_delivery')->where(['deliver' => $idRegex]);
Route::post('mon-panier/livraison/chosedate-{deliver}-{delivery_date}-{delivery_slot}', [CartController::class, 'chosed_delivery_date'])->name('cart.chosed_delivery_date')->where(['deliver' => $idRegex,'delivery_date' => $slugRegex,'delivery_slot' => $slugRegex]);
Route::post('mon-panier/sommaire', [CartController::class, 'cart_summary'])->name('cart.summary');
