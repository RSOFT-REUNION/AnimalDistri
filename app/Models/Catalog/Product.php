<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'catalog_products';

    protected $fillable = ['code_article', 'name', 'slug', 'brands', 'fav_image', 'short_description', 'content', 'composition', 'tags', 'barcode', 'weight_unit', 'weight', 'price_ht','tva','price_ttc','stock', 'stock_unit', 'active', 'created_by_id','updated_by_id', 'deleted_by_id' ];

    public $images_directory = '/upload/catalog/products/';

    public function category () {
        return $this->belongsTo(Category::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany (Category::class, 'catalog_product_categories');
    }

    public function brands (): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductsImages::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function getStockQuantity($product) {
        if ($product->stock == 0) {
            return 'Rupture de stock';
        } elseif ($product->stock_unit == 'unit' ) {
            return $product->stock / 1000 ;
        } else {
            return formatStockToFloat($product->stock).' '.$product->stock_unit;
        }
    }

    public function getFirstImagesURL(?int $width = null, ?int $height = null, ?string $fit = null)
    {
        if($this->fav_image){
            $fav_image = $this->images()->where('id', $this->fav_image)->first();
            if($fav_image){
                return getImageUrl($this->images_directory.$this->id.'/'.$fav_image->name, $width, $height, $fit);
            } else {
                return getImageUrl($this->images_directory.$this->id.'/'.$this->images->first()->name,$width, $height, $fit);
            }
        } elseif ($this->images->count() > 0) {
            return getImageUrl($this->images_directory.$this->id.'/'.$this->images->first()->name,$width, $height, $fit);
        }
    }

     public function attachImages($product, array $images)
     {
         $pictures = [];
         foreach ($images as $image) {
             if ($image->getError()){
                 continue;
             }
             $image_name = Str::slug($image->getClientOriginalName(), '.');
             $image->storeAs('public/'.$this->images_directory.$product.'/', $image_name);
             chmod(base_path().'/public/storage/upload/catalog/products/'.$product,0775);
             $pictures[] = [
                 'name' => $image_name,
             ];
         }
         if(count($pictures) > 0){
             $this->Images()->createMany($pictures);
         }
     }
}
