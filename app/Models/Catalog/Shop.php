<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    protected $table = 'catalog_shops';

    protected $fillable = ['name', 'image', 'address', 'postal_code', 'city', 'description', 'schedules', 'visibility'];

    /**
     * Retourne l'adresse du magasin
     */
    public function getShopAddress($shop_id)
    {
        $shop = Shop::find($shop_id)->select('address', 'postal_code', 'city')->first();
        $address = $shop->address ?? '';
        $postalCode = $shop->postal_code ?? '';
        $city = $shop->city ?? '';
        return $address . ' ' . $postalCode . ' ' . $city;
    }

}
