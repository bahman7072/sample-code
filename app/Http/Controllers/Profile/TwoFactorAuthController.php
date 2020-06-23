<?php

namespace App\Http\Controllers\Profile;

use App\ActiveCode;
use App\Http\Controllers\Controller;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TwoFactorAuthController extends Controller
{
    public function manageTwoFactor()
    {
        return view('profile.two-factor-auth');
    }

    public function postManageTwoFactor(Request $request)
    {
        $data = $this->validateRequestData($request);

        if ($this->isRequestTypeSms($data)){
            if ($request->user()->phone !== $data['phone']){
                return $this->createCodeAndSendSms($request, $data);
            }else{
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }
        }

        if ($this->isRequestTypeOff($data)){
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }

        return back();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRequestData(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:off,sms',
            'phone' => ['required_unless:type,off', Rule::unique('users')->ignore($request->user()->id)]
        ]);
        return $data;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isRequestTypeSms(array $data): bool
    {
        return $data['type'] === 'sms';
    }

    /**
     * @param Request $request
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createCodeAndSendSms(Request $request, array $data)
    {
        $code = ActiveCode::generateCode($request->user());
        $request->session()->flash('phone', $data['phone']);

        $request->user()->notify(new ActiveCodeNotification($code, $data['phone']));

        return redirect(route('profile.2fa.phone'));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isRequestTypeOff(array $data): bool
    {
        return $data['type'] === 'off';
    }
}
