<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try{
            $googleUser = Socialite::driver('google')->user();
            $user = User::whereEmail($googleUser->email)->first();

            if (!$user){
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(\Str::random(16)),
                    'two_factor_type' => 'off'
                ]);
            }

            if (! $user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
            }

            auth()->loginUsingId($user->id);
            return $this->loggedIn($request, $user) ?: redirect('/');

            alert()->success('ورود شما با موفقیت انجام شد', 'موفق');
            return redirect('/');
        } catch (\Exception $e){
            //TODO Loge Error Message
            alert()->error('ورود از طریق گوگل موفق نبود', 'خطا')->persistent('بسیار خب');
            return redirect('/login');
        }
    }
}
