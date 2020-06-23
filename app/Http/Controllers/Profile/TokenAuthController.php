<?php

namespace App\Http\Controllers\Profile;

use App\ActiveCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenAuthController extends Controller
{
    public function getPhoneVerify(Request $request)
    {
        if (!$request->session()->has('phone')){
            return redirect(route('two.factor.manage'));
        }

        $request->session()->reflash();
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('phone')){
            return redirect(route('two.factor.manage'));
        }

        $status = ActiveCode::verifyCode($request->token, $request->user());
        if ($status){
            $this->deleteUserActiveCodeAndUpdateUserPhoneAndAlertMessage($request);
        } else {
            alert()->error('شماره تلفن و احرازهویت دو مرحله ای شما تایید نشد', 'عملیات نا موفق بود');
        }

        return redirect(route('two.factor.manage'));
    }

    /**
     * @param Request $request
     */
    public function deleteUserActiveCodeAndUpdateUserPhoneAndAlertMessage(Request $request): void
    {
        $request->user()->activeCode()->delete();
        $request->user()->update([
            'phone' => $request->session()->get('phone'),
            'two_factor_type' => 'sms'
        ]);

        alert()->success('شماره تلفن و احرازهویت دو مرحله ای شما تایید شد', 'عملیات موفقیت آمیز بود');
    }
}
