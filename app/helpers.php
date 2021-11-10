<?php

use App\Http\Resources\rooms\AdminRoomResource;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

if (!function_exists('tryCatch')) {
    function tryCatch($callB, $successMg, $errorMsg, $trueStatus = true)
    {
        try {
            $callB();

            return [
                'status' => $trueStatus,
                'msg' => $successMg
            ];

        } catch (\Exception $exception) {
            return [
                'status' => false,
                'msg' => $errorMsg
            ];
        }
    }
}

if(!function_exists('forEvery')){
    function forEvery($items, $callB)
    {
        foreach ($items as $item){
            $callB($item);
        }
    }
}

if(!function_exists('ifIsSuperUser')){
    function ifIsSuperUser($callB){

        if (Auth::user()->isSuperUser()) {
            return $callB();
        }

        return response()->json([
            'message'=>'شما اجازه دسترسی به این صفحه را ندارید'
        ],403);
    }
}
