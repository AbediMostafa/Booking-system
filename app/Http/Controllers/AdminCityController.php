<?php

namespace App\Http\Controllers;

use App\Http\Resources\rooms\AdminRoomResource;
use App\Models\City;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminCityController extends Controller
{
    public function index()
    {
        return AdminRoomResource::collection(City::paginate(10));
    }

    public function search(Request $request)
    {
        return AdminRoomResource::collection(
            City::where('name', 'like', '%' . $request->get('search') . '%')->paginate(10)
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
            if ($city->rooms->count()) {
                return [
                    'status' => false,
                    'msg' => "شهر $city->name اتاق هایی دارد و نمیتواند پاک شود"
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

    public function update(City $city)
    {

        $media = $city->medias()->first();
        return [
            'cityName' => $city->name,
            'city' => $city->only('id', 'name'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
        ];
    }

    public function detachMedia(Media $media)
    {
        $media->media_of = 'other';
        $media->place = 'other';
        $media->mediaable_id = null;
        $media->mediaable_type = null;
        $media->save();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(City $city, Media $media)
    {
        $media->media_of = 'city';
        $media->place = 'front';
        $media->save();

        $city->medias()->save($media);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }

    public function change(Request $request, City $city)
    {
        $city->update([
            'name' => $request->input('name')
        ]);

        return [
            'status' => true,
            'msg' => 'بروزرسانی با موفقیت انجام شد.'
        ];
        try {
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در بروزرسانی شهر'
            ];
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'city.name'=>'required',
            'media.id'=>'exists:media,id'
        ]);

        $city = City::create([
            'name'=>$request->input('city.name')
        ]);

        $media = Media::findOrFail($request->input('media.id'));
        $media->update([
            'media_of'=>'city',
            'place'=>'front'
        ]);

        $city->medias()->save($media);

        return[
            'status'=>true,
            'msg'=>'شهر با موفقیت ایجاد شد'
        ];
    }
}
