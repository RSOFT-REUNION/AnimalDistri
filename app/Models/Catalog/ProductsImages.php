<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Glide\Urls\UrlBuilderFactory;

class ProductsImages extends Model
{
    use HasFactory;

    protected $table = 'catalog_products_images';

    protected $fillable = ['name'];

    public function getImageUrl(?int $width = null, ?int $height = null, ?string $fit = null)
    {
        if ($width === null) {
            return '/storage/upload/catalog/products/'.$this->product_id.'/'.$this->name;
        }
        $urlBuilder = UrlBuilderFactory::create('/images/', config('laravel-glide.key'));
        return $urlBuilder->getUrl('/images/upload/catalog/products/'.$this->product_id.'/'.$this->name, ['w' => $width, 'h' => $height, 'fit' => $fit]);
    }

}
