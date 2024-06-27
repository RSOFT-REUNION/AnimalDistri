<?php

namespace App\Models\Orders;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProducts extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'orders_id',
        'carts_id',
        'product_id',
        'erp_id',
        'name',
        'short_description',
        'fav_image',
        'barcode',
        'weight_unit',
        'weight',
        'stock_unit',
        'price_ht',
        'tva',
        'price_ttc',
        'discount_id',
        'discount_percentage',
        'discount_fixed_price_ttc',
        'quantity',
    ];

    public function Oders(): HasMany
    {
        return $this->hasMany(Orders::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
