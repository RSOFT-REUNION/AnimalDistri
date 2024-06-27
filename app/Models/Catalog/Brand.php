<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Brand extends Model
{
    protected $table = 'catalog_brands';

    protected $fillable = ['erp_id', 'name', 'slug', 'image', 'short_description', 'active'];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
