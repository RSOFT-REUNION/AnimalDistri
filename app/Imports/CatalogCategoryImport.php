<?php

namespace App\Imports;

use App\Models\Catalog\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CatalogCategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $i = 0;
        $logtxt = 'Import Le '. date('Y-m-d H:i:s').PHP_EOL ;
        $categorie = Category::all();

        /*** Mise a jour des categorie principal
        $categorieArray = array_column($categorie->toArray(), 'name');
        $rowsName_famille = array_column($rows->toArray(), 'name_famille');
        $uniqueName_famille = array_unique($rowsName_famille);
        $diffName_famille = array_diff($uniqueName_famille, $categorieArray);
        $intersectName_famille = array_intersect($uniqueName_famille, $categorieArray);
        ***/

        $children_categories = $rows->where('id_sous_famille', '!=' ,'NULL')->all();
        $category1Slug = $categorie->firstWhere('id', 1)->slug;
        $category2Slug = $categorie->firstWhere('id', 2)->slug;

        foreach ($children_categories as $children_category)
        {
            $children_category["slug"] =  $category1Slug.'/'.Str::slug($children_category["name_sous_famille"]);
            // Verifie que la categorie existe
            if ($categorie->contains('erp_id_famille', $children_category["id_sous_famille"])) {
                $cat = $categorie->firstWhere('erp_id_famille', $children_category["id_sous_famille"]);
                if($children_category["sysmodifieddate"] > $cat->updated_at){
                    $cat->name = $children_category["name_sous_famille"];
                    $cat->slug = $children_category["slug"];
                    $cat->save();
                    $i++;
                    $logtxt .= $children_category["name_sous_famille"].' : a ete mise a jour'.PHP_EOL;
                } else {
                    $i++;
                    $logtxt .= $children_category["name_sous_famille"].' : exist deja'.PHP_EOL;
                }
            } else {
                if ($children_category["id_famille"] == 'SURGELE') {
                    $children_category["category_id"] = 1;
                    Category::create([
                        'name'     => $children_category['name_sous_famille'],
                        'erp_id_famille'    => $children_category['id_sous_famille'],
                        'category_id'    => $children_category['category_id'],
                        'slug'    => $children_category['slug'],
                        'image'  => Str::slug($children_category["name_sous_famille"]).'.png',
                    ]);
                    $i++;
                    $logtxt .= $children_category["name_sous_famille"].' : a ete ajouter'.PHP_EOL;
                } elseif ($children_category["id_famille"] == 'EPICERIE') {
                    $children_category["category_id"] = 2;
                    Category::create([
                        'name'     => $children_category['name_sous_famille'],
                        'erp_id_famille'    => $children_category['id_sous_famille'],
                        'category_id'    => $children_category['category_id'],
                        'slug'    => $children_category['slug'],
                        'image'  => Str::slug($children_category["name_sous_famille"]).'.png',
                    ]);
                    $i++;
                    $logtxt .= $children_category["name_sous_famille"].' : a ete ajouter'.PHP_EOL;
                }
            }
        }
        Storage::disk('local')->put('/import/catalog/categories/import_'.date('Y_m_d_H_i_s').'.txt', $logtxt);
    }
}
