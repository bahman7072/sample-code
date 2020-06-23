<?php

namespace App\Http\Controllers\Auth;

use App\ActiveCode;
use App\Http\Controllers\Controller;
use App\Notifications\LoginToWebsiteNotification;
use App\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (!$request->session()->has('auth')){
            return redirect(route('login'));
        }

        $request->session()->reflash();
        return view('auth.token');
    }

    public function postToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('auth')){
            return redirect(route('login'));
        }

        $user = User::findOrFail($request->session()->get('auth.user_id'));
        $status = ActiveCode::verifyCode($request->token, $user);

        if (!$status){
            alert()->error('کد وارد شده صحیح نیست', 'نا موفق');
            return redirect(route('login'));
        }

        if (auth()->loginUsingId($user->id, $request->session()->get('auth.remember'))){
            $user->notify(new LoginToWebsiteNotification());
            $user->activeCode()->delete();
            alert()->success('ورود شما با موفقیت انجام شد', 'موفق');

            return redirect('/');
        }

        return redirect(route('login'));
    }
}
