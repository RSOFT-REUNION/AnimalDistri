<?php

namespace App\Models\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'catalog_discounts';
    protected $fillable = [
        'ref_discount',
        'name',
        'percentage',
        'icon',
        'short_description',
        'discount_type',
        'start_date',
        'end_date',
        'active'
    ];

    public function products(): hasMany
    {
        return $this->hasMany(DiscountProduct::class);
    }

    public function isCurrentlyActive()
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    public function scopeCurrently($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('active', 1);
    }
}
