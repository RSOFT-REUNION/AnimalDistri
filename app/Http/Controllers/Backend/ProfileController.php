<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return view('backend.auth.profile', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        return Redirect::route('backend.profile.edit')->with('success', 'Mise à jour effectuée');
    }

    public function updatePassword(Request $request)
    {
        $currentPassword = $request->input('currentPassword');
        $newpassword = Hash::make($request->input('newPassword'));

        if(!Hash::check($currentPassword, $request->user()->password)) {
            return Redirect::route('backend.profile.edit')->with('error', 'Le mot de passe actuel ne correspond pas.');
        }

        if($request->input('newPassword') != $request->input('confirmNewPassword')){
            return Redirect::route('backend.profile.edit')->with('error', 'Les mots de passe sont différents.');
        }

        $request->user()->update([
            'password' => $newpassword,
        ]);
        return Redirect::route('backend.profile.edit')->with('success', 'Mise à jour du mot de passe effectué');
    }
}
