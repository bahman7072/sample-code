<?php
/**
 * Created by PhpStorm.
 * User: Bahman
 * Date: 16/04/2020
 * Time: 02:14 PM
 */

namespace App\Http\Controllers\Auth;


use App\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use App\Notifications\LoginToWebsiteNotification;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedIn(Request $request, $user)
    {
        if ($user->hasTwoFactorAuthenticatedEnabled()){
           return $this->logoutAndRedirectToTokenEntry($request, $user);
        }

        $user->notify(new LoginToWebsiteNotification());
        return false;
    }

    public function logoutAndRedirectToTokenEntry(Request $request, $user)
    {
        auth()->logout();

        $request->session()->flash('auth', [
            'user_id' => $user->id,
            'using_sms' => false,
            'remember' => $user->remember
        ]);

        if ($user->hasSmsTwoFactorAuthenticationEnabled()){
            $code = ActiveCode::generateCode($user);

            $user->notify(new ActiveCodeNotification($code, $user->phone));

            $request->session()->push('auth.using_sms', true);
        }
        return redirect(route('2fa.token'));
    }
}