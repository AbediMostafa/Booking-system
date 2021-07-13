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

        $randomNumber = random_int(100000, 999999);

        try {

            $ultra = new UltraFastSendSms();
            $result = $ultra->generateData(
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

            $user = User::firstOrCreate([
                'email' => session('phoneRegistration.phoneNumber')
            ]);

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
