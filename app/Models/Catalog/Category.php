<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'catalog_categories';
    protected $fillable = ['erp_id_famille', 'name', 'description', 'slug', 'category_id', 'image', 'is_menu', 'active'];

    public function categories(): HasMany {
        return $this->hasMany(Category::class);
    }
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    public function childrenCategories(): HasMany {
        return $this->hasMany(Category::class)->orderBy('order')->with('categories');
    }

    public function getCategoryName($category_id) {
        if(empty(Category::where('id', '=', $category_id)->pluck('name')->first())){
            return 'Aucune catégorie';
        } else {
            return Category::where('id', '=', $category_id)->pluck('name')->first();
        }
    }

    public function getChildren($category) {
        return $this->where('category_id', '=', $category)->pluck('id');
    }

    /*** function Copilot ***/
    public function getAllDescendantsRecursive($category)
    {
        $descendants = collect();
        $categoryChildren = $this->getChildren($category);
        foreach ($categoryChildren as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendantsRecursive($child));
        }
        return $descendants;
    }

}
