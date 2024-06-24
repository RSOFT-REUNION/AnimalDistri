<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'catalog_brands';

    protected $fillable = ['name', 'slug', 'image', 'description'];

}
