<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\PseudoTypes\False_;

class ConfirmNumberController extends Controller
{
    public function getConfirmNumber(Request $request)
    {
        $request->validate([
            'phoneNumber' => 'required|numeric'
        ]);

        session(['phoneRegistration' => [
            'phoneNumber' => $request->input('phoneNumber'),
            'code' => 1234
        ]]);

        return [
            'status' => true,
        ];
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
