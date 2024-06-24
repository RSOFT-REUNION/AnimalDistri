<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'content_categories';
    protected $fillable = ['name', 'slug', 'category_id'];

    public function pages(): HasMany {
        return $this->hasMany(Pages::class);
    }

    public function categories(): HasMany {
        return $this->hasMany(Category::class);
    }
    public function childrenCategories(): HasMany {
        return $this->hasMany(Category::class)->with('categories');
    }
    public function getCategoryName($categorie_id) {
        if(empty(Category::where('id', '=', $categorie_id)->pluck('name')->first())){
            return 'Aucune catégorie';
        } else {
            return Category::where('id', '=', $categorie_id)->pluck('name')->first();
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
