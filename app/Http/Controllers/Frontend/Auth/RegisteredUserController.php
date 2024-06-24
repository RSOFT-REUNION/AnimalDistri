<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Models\Users\Address;
use App\Models\Users\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\NoSemicolon;

class RegisteredUserController extends FrontendBaseController
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->newsletter = $request->newsletter == 'on' ? 1 : 0;
        $request->validate([
            'civility' => ['required'],
            'first_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'last_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'address' => ['required', 'string', 'max:255', new NoSemicolon],
            'address2' => ['nullable', 'string', 'max:255', new NoSemicolon],
            'cities' => ['required', 'string', 'max:255', new NoSemicolon],
            'phone' => ['required', 'string', 'max:255', new NoSemicolon],
            'birthday' => ['required', 'date', 'max:255', new NoSemicolon],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, new NoSemicolon],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), new NoSemicolon],
        ]);

        $user = User::create([
            'civility' => $request->civility,
            'name' => $request->first_name .' '. $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'newsletter' => $request->newsletter,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



        /* Creation de l'adresse */
        $adresse = Address::create([
            'user_id' => $user->id,
            'alias' => $request->first_name .' '. $request->last_name,
            'civility' => $request->civility,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'address2' => $request->address2,
            'cities' => $request->cities,
            'phone' => $request->phone,
        ]);
        $adresse->favorite = $adresse->id;
        $adresse->save();

        if($user && $adresse){
            $this->exportUserInfos($user->id);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }


    public function exportUserInfos($user_id) {
        $user = User::where('id', '=', $user_id)->first();
        $address = Address::where('user_id', '=', $user->id)->first();

        $Userkeys = ['id', 'civility', 'name', 'last_name', 'first_name', 'phone', 'email', 'birthday'];
        $Addresskeys = ['address', 'address2', 'cities'];

        $filteredUserList =  array_intersect_key($user->toArray(), array_flip($Userkeys));
        $filteredAddressList = array_intersect_key($address->toArray(), array_flip($Addresskeys));

        $filteredList = [$filteredUserList+$filteredAddressList];

        //dd($filteredList);
        $filename = 'export_'.date('Y_m_d_H_i_s').'_user_'.$user->id.'.csv';

        // Ajoutez des en-têtes pour chaque colonne dans le téléchargement CSV
        array_unshift($filteredList, array_keys($filteredList[0]));

        // Générer le contenu CSV
        $csvContent = '';
        $callback = function() use ($filteredList, &$csvContent) {
            $FH = fopen('php://temp', 'r+');
            foreach ($filteredList as $row) {
                fputcsv($FH, $row, ';');
            }
            rewind($FH);
            $csvContent = stream_get_contents($FH);
            fclose($FH);
        };

        $callback();

        // Utilisez le système de fichiers pour stocker le fichier CSV
        Storage::disk('local')->put('exports/users/'.$filename, $csvContent);
    }

}


