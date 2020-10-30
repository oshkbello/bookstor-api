<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialAccountController extends Controller
{
    //
    public function redirectToProvider($provider)
    {
        /** Used to redirect to any social provider,
        **  socialite handles all commuincation and authentication between 
        *   Our app and the social provider. 
        * Social provider grants us a access token after authentication
        */
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        //Try block to catch any future errors from provider
        try {  
            //save all user information recieved from authentication 
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }
}
