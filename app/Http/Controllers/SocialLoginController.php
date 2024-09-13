<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
   public function redirect($provider){
        return Socialite::driver($provider)->redirect();
   }

   public function callback($provider){
        $user = Socialite::driver($provider)->user();
        // dd($user);
        $socialUser = User::updateOrCreate([
            'provider_id' => $user->id,
        ], [
            'name' => $user->name,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'provider' => $provider,
            'provider_token' => $user->token,
            'role' => 'user',
        ]);

        Auth::login($socialUser);

        return to_route('userHome');
   }

}
