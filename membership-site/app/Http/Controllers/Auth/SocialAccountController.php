<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SocialAccount;
use Socialite;
use App\User;

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

        return redirect('/home');
    }

    public function findOrCreateUser($socailUser, $provider)
    {
        //find existing account by social provider
        $account = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $socailUser->getId()->first());
        
        if ($account) {
            return $account->user;
        } else {

            //find existing account by email
            $user = user::where('email', $socailUser->getEmail())->first();

            //if no user, create new db user entry
            if (! $user) {
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName()
                ]);
            }

            //Add provider record to the user
            $user->accounts()->create([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId()
            ]);

            return $user;
        }
    }
}
