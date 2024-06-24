<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pages extends Model
{
    protected $table = 'content_pages';
    protected $fillable = ['name', 'slug', 'description', 'content','active', 'is_menu', 'user_id', 'user_id_update'];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    /**
     * Retourne le nom de la categorie
     */
    public function getCategoryName($categorie_id) {

        if(empty(Category::where('id', '=', $categorie_id)->pluck('name')->first())){
            return 'Aucune catégorie';
        } else {
            return Category::where('id', '=', $categorie_id)->pluck('name')->first();
        }
    }

}
