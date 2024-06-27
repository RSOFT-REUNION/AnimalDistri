<?php

namespace App\Imports;

use App\Models\Catalog\Discount;
use App\Models\Catalog\DiscountProduct;
use App\Models\Catalog\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatalogDiscountProductsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        $logtxt = 'Import Le ' . date('Y-m-d H:i:s') . PHP_EOL;
        $discouts = Discount::all();
        $discoutsProducts = DiscountProduct::all();
        $products = Product::all();
        foreach ($rows as $import_disountProduct) {
            $discout_id = $discouts->firstWhere('ref_discount', $import_disountProduct["ref_discount"])->id;
            $product_id = $products->firstWhere('erp_id', $import_disountProduct["product_id"])->id;
            $fixedprice_ttc = intval($import_disountProduct["fixedprice_ttc"] * 100);

            if ($discoutsProducts->contains('erp_id', $import_disountProduct["product_id"])) {
                $discout = $discouts->firstWhere('erp_id', $import_disountProduct["product_id"]);
                $discoutProduct = $discoutsProducts->firstWhere('erp_id', $import_disountProduct["product_id"]);
                if ($import_disountProduct["sysmodifieddate"] > $discoutProduct->updated_at) {
                    $discoutProduct->fixed_priceTTC = $fixedprice_ttc;
                    $discoutProduct->save();
                    $i++;
                    $logtxt .= $import_disountProduct["ref_discount"] . ' - ' . $import_disountProduct["product_id"] . ' : est mis a jour' . PHP_EOL;
                } else {
                    $i++;
                    $logtxt .= $import_disountProduct["ref_discount"] . ' - ' . $import_disountProduct["product_id"] . ' : existe deja' . PHP_EOL;
                }
            } else {
                DiscountProduct::create([
                    'discount_id' => $discout_id,
                    'product_id' => $product_id,
                    'erp_id' => $import_disountProduct["product_id"],
                    'fixed_priceTTC' => $fixedprice_ttc
                ]);
                $i++;
                $logtxt .= $import_disountProduct["ref_discount"] . ' - ' . $import_disountProduct["product_id"] . ' : a ete ajouté' . PHP_EOL;
            }
        }
        Storage::disk('local')->put('/import/catalog/discounts/import_products_' . date('Y_m_d_H_i_s') . '.txt', $logtxt);
    }
}
