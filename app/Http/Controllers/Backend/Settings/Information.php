<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Informations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Information extends Controller
{
    /**
     * Informations
     */
    public function index()
    {
        return view('backend.settings.informations.index', [
            'infos' => Informations::where('id', 1)->first()
        ]);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'address' => 'required|string|max:250',
            'phone' => 'required|string',
            'fax' => '',
        ]);
        Informations::where('id', 1)->update($validated);
        return back()->with('success', 'Mise à jour effectuée avec success');
    }
    /**
     * Mentions Legale
     */
    public function legalnoticeindex()
    {
        return view('backend.settings.informations.legalnotice', [
            'infos' => Informations::select('legalnotice')->where('id', 1)->first()
        ]);
    }
    public function legalnoticeupdate(Request $request)
    {
        Informations::where('id', 1)->update(['legalnotice' => $request->input('legalnotice')]);
        return back()->with('success', 'Mise à jour effectuée avec success');
    }
    /**
     * Mentions Legale
     */
    public function termsofserviceindex()
    {
        return view('backend.settings.informations.termsofservice', [
            'infos' => Informations::select('termsofservice')->where('id', 1)->first()
        ]);
    }
    public function termsofserviceupdate(Request $request)
    {
        Informations::where('id', 1)->update(['termsofservice' => $request->input('termsofservice')]);
        return back()->with('success', 'Mise à jour effectuée avec success');
    }
}
