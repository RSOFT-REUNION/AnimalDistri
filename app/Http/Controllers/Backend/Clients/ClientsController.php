<?php

namespace App\Http\Controllers\Backend\Clients;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Carts\Carts;
use App\Models\Users\Address;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.clients.index', [
            'clients' => User::orderBy('id','DESC')->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $client)
    {
        $client->delete();
        return back()->withSuccess('Clients supprimée avec succès');
    }

    /**
     * Liste des adresses du client
     */
    public function addresses(User $client)
    {
        return view('backend.clients.addresses', [
            'client' => $client,
            'addresses' => Address::where('user_id', '=', $client->id)->get(),
        ]);
    }

    /**
     * Display a listing of Carts.
     */
    public function carts_index()
    {
        /*** Mise a jour des status en Abandonner apres 1 Mois ***/
        $carts = Carts::where('status', 'En cours')->orderBy('id','DESC')->get();
        foreach ($carts as $cart) {
            $d = date("Y-m-d\\TH:i",strtotime("-1 Months"));
            if($cart->created_at <= $d){
                $cart->status = "Abandonner";
                $cart->save();
            }
        }
        return view('backend.clients.carts', [
            'carts' => Carts::orderBy('id','DESC')->get()
        ]);
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport(), $request->csv, $request->csv);
        return back()->withSuccess('Clients importer avec succès');
    }

}
