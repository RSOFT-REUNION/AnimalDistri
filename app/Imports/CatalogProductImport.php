<?php

namespace App\Imports;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatalogProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $i = 0;
        $logtxt = 'Import Le '. date('Y-m-d H:i:s').PHP_EOL ;
        $products = Product::all();
        $categorie = Category::all();

        foreach ($rows as $import_product) {
            $import_product["slug"] =  Str::slug($import_product["name"]);
            $import_product["active"] =  1;

            if (empty($import_product["code_sous_famille"])) {
                if (empty($import_product["code_famille"])) {
                    $i++;
                    $logtxt .= $import_product["code_article"].' - '.$import_product["name"].' : NA PAS ETE IMPORTER'.PHP_EOL;
                    continue;
                }
                $categorieid = $categorie->firstWhere('erp_id_famille', $import_product["code_famille"])->id;
            } else {
                $categorieid = $categorie->firstWhere('erp_id_famille', $import_product["code_sous_famille"])->id;
            }
            $import_product["slug"] =  Str::slug($import_product["name"]);
            // Modification de la valeur de wieght_unit
            if ($import_product["wieght_unit"] == 1) $import_product["wieght_unit"] = 'kg';
            if ($import_product["wieght_unit"] == 2) $import_product["wieght_unit"] = 'l';
            if ($import_product["wieght_unit"] == 'NULL') $import_product["wieght_unit"] = 'unit';
            // Modification de la valeur de stock_unit
            if ($import_product["stock_unit"] == 1) $import_product["stock_unit"] = 'kg';
            if ($import_product["stock_unit"] == 2) $import_product["stock_unit"] = 'l';
            if ($import_product["stock_unit"] == 3) $import_product["stock_unit"] = 'unit';

            $import_product['price_ht'] = intval($import_product['price_ht'] * 100);
            $import_product['taux_de_tva'] = intval($import_product['taux_de_tva'] * 100);
            $import_product['price_ttc'] = intval($import_product['price_ttc'] * 100);
            $import_product['stock'] = intval($import_product['stock'] * 1000);

            /***
             * Manque les images et les labels *
             ***/

            // Verifies que le produit existe pour le mettre a jour
            if ($products->contains('code_article', $import_product["code_article"])) {
                $product = $products->firstWhere('code_article', $import_product["code_article"]);
                if($import_product["sysmodifieddate"] > $product->updated_at){
                    $product->name = $import_product["name"];
                    $product->slug = $import_product["slug"];
                    $product->short_description = $import_product["short_description"];
                    $product->composition = $import_product["composition"];
                    $product->weight = $import_product["weight"];
                    $product->wieght_unit = $import_product["wieght_unit"];
                    $product->price_ht = $import_product["price_ht"];
                    $product->tva = $import_product["tva"];
                    $product->price_ttc = $import_product["price_ttc"];
                    $product->stock_unit = $import_product["stock_unit"];
                    $product->stock = $import_product["stock"];
                    $product->barcode = $import_product["barcode"];
                    $product->save();
                    $i++;
                    $logtxt .= $import_product["code_article"].' - '.$import_product["name"].' : a ete mise a jour'.PHP_EOL;
                } else {
                    $i++;
                    $logtxt .= $import_product["code_article"].' - '.$import_product["name"].' : exist deja'.PHP_EOL;
                }
            }
            else {
                $p = Product::create([
                    'code_article'     => $import_product['code_article'],
                    'name'     => $import_product['name'],
                    'category_id'     => $categorieid,
                    'slug'     => $import_product['slug'],
                    'short_description'     => $import_product['short_description'],
                    'composition'     => $import_product['composition'],
                    'weight'     => $import_product['weight'],
                    'wieght_unit'     => $import_product['wieght_unit'],
                    'price_ht'     => $import_product['price_ht'],
                    'tva'     => $import_product['taux_de_tva'],
                    'price_ttc'     => $import_product['price_ttc'],
                    'stock_unit'     => $import_product['stock_unit'],
                    'stock'     => $import_product['stock'],
                    'barcode'     => $import_product['barcode'],
                    'active'     => $import_product['active'],
                ]);
                $i++;
                $logtxt .= $import_product["name"].' : a ete ajouter'.PHP_EOL;
            }
        }
        Storage::disk('local')->put('/import/catalog/products/import_'.date('Y_m_d_H_i_s').'.txt', $logtxt);
    }
}
