<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;
class SocialiteAuthController extends Controller
{
  public function redirect($provider) {
    return Socialite::driver($provider)->redirect();
  }

  public function callback($provider) {
    try {
      $SocialUser = Socialite::driver($provider)->user();
    
      if (User::where('email', $SocialUser->email)->where('provider_type','!=',$provider)->exists()) {
        return redirect()->route('login')->withErrors(['email' => 'this email use with diffrent social media app']);
      }
      $user = User::where('provider_type', $provider)->where('provider_id', $SocialUser->id)->first();
      if (blank($user)) {
        $auth_name = 'Unkonown';
        if(isset($SocialUser->nickname)){
          $auth_name = $SocialUser->nickname;
        }else if(isset($SocialUser->name)){
          $auth_name = $SocialUser->name; 
        }
        
        $user = User::create([
          'name' => $auth_name,
          'email' => $SocialUser->email,
          'provider_token' => $SocialUser->token,
          'provider_type' => $provider,
          'provider_id' => $SocialUser->id,
        ]);
      }

      Auth::login($user);
      return redirect()->route('home');
    }catch(\Exception $e) {
      throw $e->getMessage();
    }
  }
}