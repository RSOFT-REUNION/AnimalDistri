<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountProduct extends Model
{
    use HasFactory;
    protected $table = 'catalog_discounts_products';
    protected $fillable = [
        'discount_id',
        'product_id',
        'erp_id',
        'fixed_priceTTC',
        'active'
    ];

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
