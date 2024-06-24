<?php

namespace App\Imports;

use App\Models\Catalog\Discount;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatalogDiscountImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        $logtxt = 'Import Le ' . date('Y-m-d H:i:s') . PHP_EOL;
        $discouts = Discount::all();

        foreach ($rows as $import_disount) {
            if ($discouts->contains('ref_discount', $import_disount["ref_discount"])) {
                $discout = $discouts->firstWhere('ref_discount', $import_disount["ref_discount"]);
                if ($import_disount["sysmodifieddate"] > $discout->updated_at) {
                    $discout->name = $import_disount["name"];
                    $discout->start_date = $import_disount["startdate"];
                    $discout->end_date = $import_disount["enddate"];
                    $i++;
                    $logtxt .= $import_disount["ref_discount"] . ' - ' . $import_disount["name"] . ' : a ete mise a jour' . PHP_EOL;
                } else {
                    $i++;
                    $logtxt .= $import_disount["ref_discount"] . ' - ' . $import_disount["name"] . ' : exist deja' . PHP_EOL;
                }
            } else {
                Discount::create([
                    'ref_discount' => $import_disount["ref_discount"],
                    'name' => $import_disount["name"],
                    'start_date' => $import_disount["startdate"],
                    'end_date' => $import_disount["enddate"],
                ]);
                $i++;
                $logtxt .= $import_disount["ref_discount"] . ' - ' . $import_disount["name"] . ' : a ete ajouter' . PHP_EOL;
            }
        }
        Storage::disk('local')->put('/import/catalog/discounts/import_' . date('Y_m_d_H_i_s') . '.txt', $logtxt);
    }
}
