<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Http\Requests\Frontend\Auth\ProfileUpdateRequest;
use App\Models\Orders\Orders;
use App\Models\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends FrontendBaseController
{
    public function index()
    {
        $user = Auth::user();
        if($user->created_at == $user->updated_at) {
            return view('frontend.auth.change-password');
        }

        return view('frontend.profile.partials.index');
    }


    /**
     * Informations
     */
    public function info_edit(Request $request)
    {
        return view('frontend.profile.partials.informations', [
            'user' => $request->user(),
        ]);
    }
    public function info_update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('info.edit')->with('status', 'profile-updated');
    }
    public function info_newsletter(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->input('value') == "off") {
            $user->newsletter = 0;
        } elseif ($request->input('value') == "on") {
            $user->newsletter = 1;
        }
        $user->save();

        // Retourne une vue partielle
        return view('frontend.profile.partials.informations');
    }
    /**
     * Orders
     */
    public function orders_show()
    {
        return view('frontend.profile.partials.orders', [
            'orders' => Orders::with('product')->where('user_id', Auth::user()->id)->get(),
        ]);
    }

    /**
     * loyality
     */
    public function loyality_show()
    {
        $user = User::find(Auth::user()->id);
        return view('frontend.profile.partials.loyalty', [
            'user' => $user,
        ]);
    }
}
