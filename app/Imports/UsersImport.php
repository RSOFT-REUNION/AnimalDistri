<?php

namespace App\Imports;

use App\Models\Users\Address;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        $logtxt = 'Import Le '. date('Y-m-d H:i:s').PHP_EOL ;
        foreach ($rows as $csv) {
            if($csv["erp_id"] != "PASSAGE") {
                if($csv["email"] != 'NULL') {
                    $csv["erp_loyalty_points"] = intval($csv["erp_loyalty_points"]);

                    /*** Création de l'utilisateur ***/
                    $user = new User;
                    $user->name = ucfirst(strtolower(($csv["erp_lastname"].' '.$csv["prenom"])));
                    $user->last_name = ucfirst(strtolower(($csv["erp_lastname"])));
                    $user->first_name = ucfirst(strtolower(($csv["prenom"])));
                    $user->email = strtolower($csv["email"]);
                    $user->phone = $csv["phone"];
                    $user->birthday = $csv["birthday"];
                    $user->erp_id = $csv["erp_id"];
                    $user->erp_loyalty_points = $csv["erp_loyalty_points"];
                    $user->erp_loyalty_card = $csv["erp_loyalty_card"];
                    $user->active = 1;
                    $user->newsletter = 1;
                    $user->save();
                    /*** Création de l'adresse par dafault ***/
                    if(!empty($csv["address"])) {
                        $address = new Address;
                        $address->user_id = $user->id;
                        $address->alias = ucfirst(strtolower(($csv["erp_lastname"].' '.$csv["prenom"])));
                        $address->last_name = ucfirst(strtolower(($csv["erp_lastname"])));
                        $address->first_name = ucfirst(strtolower(($csv["prenom"])));
                        $address->address = $csv["address"];
                        $address->address2 = $csv["address2"];
                        $address->cities = $csv["postal_code"];
                        $address->country = "La réunion";
                        $address->phone = $csv["phone"];
                        $address->other_phone = $csv["other_phone"];
                        $address->save();
                    }
                    $i++;
                    $logtxt .= $csv["erp_id"].' : ok'.PHP_EOL;
                } else {
                    $logtxt .= $csv["erp_id"].' : Client non importé, Aucune adresse mail'.PHP_EOL;
                }
            }
        }
        Storage::disk('local')->put('/import/users/user/import_'.date('Y_m_d_H_i_s').'.txt', $logtxt);
    }
}
