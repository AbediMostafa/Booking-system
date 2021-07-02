<?php

namespace App\Http\Controllers;

use App\Http\Resources\rooms\AdminRoomResource;
use App\Models\City;
use Illuminate\Http\Request;

class AdminCityController extends Controller
{
    public function index()
    {
        return AdminRoomResource::collection(City::paginate(12));
    }

    public function search(Request $request)
    {
        return AdminRoomResource::collection(
            City::where('name', 'like', '%' . $request->get('search') . '%')->paginate(12)
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'cities' => 'required|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $cities = City::whereIn('id', $request->get('cities'))->get();

        foreach ($cities as $city) {
            if($city->rooms->count()){
                return [
                    'status'=>false,
                    'msg'=>"شهر $city->name اتاق هایی دارد و نمیتواند پاک شود"
                ];
            }
            $city->delete();
        }
        try {

            return  [
                'status' => true,
                'msg' => 'شهرها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در حذف شهرها'
            ];
        }
    }
}
