<?php

namespace App\Models\Carts;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartsProducts extends Model
{
    Protected $table = 'carts_product';

    protected $fillable = ['product_id', 'cart_id', 'fav_image', 'discount_id', 'discount_percentage', 'discount_fixed_price_ttc', 'quantity', 'stock_unit', 'price_ht', 'tva','price_ttc'];

    public function Carts(): HasMany
    {
        return $this->hasMany(Carts::class);
    }
    public function removeStorageFromURL()
    {
        return substr($this->fav_image, 8);
    }
}
