<?php

namespace App\Http\Controllers;

use App\Classes\UltraFastSendSms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmNumberController extends Controller
{
    public function getConfirmNumber(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric'
        ]);

        $randomNumber = random_int(1000, 9999);

        try {

            $ultra = new UltraFastSendSms();
            $result = $ultra->activationSms(
                $request->input('phoneNumber'),
                $randomNumber
            )->UltraFastSend();

            if(!$result){
                return [
                    'status' => false,
                    'msg' => 'خطا در ارسال پیامک'
                ];
            }

            session(['phoneRegistration' => [
                'phoneNumber' => $request->input('phoneNumber'),
                'username' => $request->input('username'),
                'code' => $randomNumber
            ]]);

            return [
                'status' => true,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'خطا در ارسال پیامک'
            ];
        }
    }

    public function submitConfirmCode(Request $request)
    {

        $request->validate([
            'confirmCode' => 'required'
        ]);

        if ($request->input('confirmCode') == session('phoneRegistration.code')) {

            $user = User::firstOrCreate(
                ['phone' => session('phoneRegistration.phoneNumber')],
                ['name' => session('phoneRegistration.username')],
            );

            Auth::login($user);

            return [
                'status' => true,
                'msg' => 'با موفقیت وارد سیستم شدید'
            ];
        }

        return [
            'status' => False,
            'msg' => 'کد وارد شده صحیح نیست'
        ];
    }
}
